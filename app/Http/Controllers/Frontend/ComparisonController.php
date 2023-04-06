<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\CommonStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCategoryResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SellerResource;
use App\Models\Comparison;
use App\Models\ProductCategory;
use App\Models\Seller;
use App\Services\CategoryService;
use App\Services\ProductSearchService;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class ComparisonController extends Controller
{
    //
    use HttpResponses;

    private ProductSearchService $productSearchService;
    private CategoryService $categoryService;

    private \Closure $productCallback;

    public function __construct()
    {
        $this->productSearchService = (new ProductSearchService());
        $this->categoryService = (new CategoryService(new ProductCategory()));
        $this->productCallback = function ($query) {
            $query->with('seller')
                ->where([
                    ['status', CommonStatus::Active]
                ])
                ->orderBy('price');
        };
    }

    public function fetchComparisonData(Request $request)
    {
        $id = $request->input('id') | 0;
        $model = Comparison
            ::with(['productCategory', 'products' => $this->productCallback])
            ->where([
                ['status', CommonStatus::Active]
            ])
            ->find($id);
        if ($model === null) {
            return $this->error([], null, 404);
        }
        $category = $model->productCategory;
        $breadcrumb = ProductCategoryResource::collection(
            $this->categoryService->breadcrumb($category->lft, $category->rgt)
        );

        $featuredSellers = ($model->products);

        return $this->success([
            'model' => $model,
            'breadcrumb' => $breadcrumb,
            'featuredSellers' => $featuredSellers,
        ]);
    }

    public function getComparisonSellers(Request $request)
    {
        $id = $request->input('id') | 0;
        $model = Comparison
            ::with(['products' => $this->productCallback])
            ->where([
                ['status', CommonStatus::Active]
            ])
            ->find($id);
        if ($model === null) {
            return $this->error([], null, 404);
        }
        $featuredSellers = ($model->products);
        return $this->success([
            'sellers' => $featuredSellers,
        ]);

    }
}
