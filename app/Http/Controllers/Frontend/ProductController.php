<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\CommonStatus;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Services\CategoryService;
use App\Services\ElasticService;
use App\Services\ProductSearchService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    //

    private ProductSearchService $productSearchService;

    public function __construct()
    {
        $this->productSearchService = (new ProductSearchService());
    }

    public function fetchCategoryData(Request $request)
    {
        $id = $request->input('id') | 0;
        $category = ProductCategory
            ::with([
                'children' => function ($query) {
                    $query->where([
                        ['status', CommonStatus::Active],
                    ]);
                },
                'sellers' => function ($query) {
                    return $query->where([
                        ['status', CommonStatus::Active],
                    ]);
                }
            ])
            ->find($id);

        $sellers = $category->sellers;
        $arrCategoryIds = $this->getArr($category);
        $query = $this->productSearchService->productsByCategory($arrCategoryIds);
        $products['data'] = $this->productSearchService->productMapper($query['hits']);
        $total = $query['total'] | 0;
        $children = $category->children ?? [];
        $staticData = compact('category', 'children', 'sellers');
        return response()->json(array_merge($staticData,
            [
                'products' => $products,
                'total' => $total,
            ]
        ));
    }

    public function filterProduct(Request $request)
    {
        $categoryId = $request->input("category") | 0;
        $sorting = $request->input('sorting');
        $max_price = $request->input('max_price') | 0;
        $min_price = $request->input('min_price') | 0;
        $page = $request->input('page') | 0;
        $seller = $request->input('seller') | 0;
        $category = ProductCategory::find($categoryId);
        $arrCategoryIds = $this->getArr($category);
        $query = $this->productSearchService->productsByCategory($arrCategoryIds, $page, $min_price, $max_price, $sorting, $seller);
        $total = $query['total'] | 0;
        $products['data'] = $this->productSearchService->productMapper($query['hits']);
        return response()->json(array_merge([
                'products' => $products,
                'total' => $total,
            ]
        ));
    }

    /**
     * @param Model|Collection|Builder|array|null $category
     * @return array
     */
    public function getArr(Model|Collection|Builder|array|null $category): array
    {
        $categoryService = (new CategoryService(new ProductCategory()));
        $arrCategoryIds = $categoryService->getArrayChildrenId($category->lft, $category->rgt);
        return $arrCategoryIds;
    }

    public function getProductUrl(Request $request)
    {
        $id = $request->input('id') | 0;
        $product = Product::find($id);
        if ($product === null) {
            return response()->json([
                'status' => 'error',
                'message' => trans('label.something_went_wrong')
            ]);
        }
        $key = "viewed_products";
        if (session()->has($key)) {
            $existing = session()->pull($key) ?? [];
            if (!in_array($id, $existing)) {
                array_push($existing, $id);
                $product->increment('hits');
                session()->put($key, $existing);
            }
        } else {
            $array = [];
            array_push($array, $id);
            $product->increment('hits');
            session()->put($key, $array);
        }
        return response()->json([
            'status' => 'success',
            'data' => $product->url,
        ]);
    }
}
