<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\CommonStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Comparison;
use App\Models\ProductCategory;
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
            ->withCount('products')
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

        $displayLimit = 4;
        $featuredSellers = ProductResource::collection($model->products->take($displayLimit));

        return $this->success([
            'model' => $model,
            'breadcrumb' => $breadcrumb,
            'featuredSellers' => $featuredSellers,
        ]);
    }

    public function getComparisonSellers(Request $request)
    {
        $id = $request->input('id') | 0;

        $sortBy = $this->validateSortBy($request);
        $sortField = $sortBy[0];
        $sortOrder = $sortBy[1];

        $model = Comparison
            ::query()
            ->where([
                ['status', CommonStatus::Active]
            ])
            ->find($id);
        if ($model === null) {
            return $this->error([], null, 404);
        }

        $layoutLimit = 5;
        $products = $model->products()->where([
            ['status', CommonStatus::Active]
        ])
            ->with(['seller'])
            ->orderBy($sortField, $sortOrder)
            ->paginate($layoutLimit);
        $featuredSellers = ProductResource::collection($products)->response()->getData(true);
        return $this->success([
            'sellers' => $featuredSellers,
        ]);

    }

    private function validateSortBy(Request $request): array
    {
        $sortBy = $request->input('sortBy');
        $sortingOptions = ['sorting-asc', 'price-asc', 'sorting-desc'];
        if (!($sortBy && in_array($sortBy, $sortingOptions))) {
            $sortBy = $sortingOptions[0];
        }
        return explode("-", $sortBy);
    }
}
