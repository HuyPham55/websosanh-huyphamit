<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\CommonStatus;
use App\Http\Resources\ComparisonResource;
use App\Http\Resources\PostCategoryResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\ProductResource;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\Comparison;
use App\Models\Product;
use App\Services\CategoryService;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class NewsController extends BaseController
{
    //
    use HttpResponses;
    private CategoryService $categoryService;

    public function __construct() {
        $this->categoryService = (new CategoryService(new BlogCategory()));

    }
    public function fetchAsideNews(Request $request)
    {
        $posts = BlogPost::where([
            ['status', CommonStatus::Active],
            ['is_popular', CommonStatus::Active]
        ])
            ->orderBy('created_at', 'DESC')
            ->orderBy('id', 'DESC')
            ->take(3)
            ->get();
        $result = PostResource::collection($posts)->response()->getData(true);
        return $this->success($result);
    }

    public function fetchModelData(Request $request) {
        $id = $request->input('id') | 0;
        $model = BlogPost::where([
                ['status', CommonStatus::Active]
            ])
            ->find($id);
        $category = $model->category;
        $breadcrumb = PostCategoryResource::collection(
            $this->categoryService->breadcrumb($category->lft, $category->rgt)
        );

        $relatedProduct = $this->getRelatedProducts();
        return $this->success([
            'model' => new PostResource($model),
            'breadcrumb' => $breadcrumb,
            'related' => $relatedProduct
        ]);
    }

    private function getRelatedProducts()
    {
        return ComparisonResource::collection(
            Comparison::withCount('products')
                ->where([
                    ['status', CommonStatus::Active],
                    ['featured', CommonStatus::Active]
                ])
                ->take(10)
                ->get()
        );
    }
}
