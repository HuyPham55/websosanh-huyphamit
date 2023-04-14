<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Comparison;
use App\Models\ProductCategory;
use App\Services\CategoryService;
use App\Services\ProductSearchService;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class SearchController extends BaseController
{
    //

    use HttpResponses;
    private ProductSearchService $productSearchService;
    private CategoryService $categoryService;
    public function __construct()
    {
        $this->productSearchService = (new ProductSearchService());
        $this->categoryService = (new CategoryService(new ProductCategory()));
    }
    public function search(Request $request) {
        $keyword = $this->getInput($request);
        if (strlen($keyword) <= 3) {
            return $this->error([]);
        }
        $result =  $this->productSearchService->suggestByKeyword($keyword);
        $items = $this->productSearchService->resultMapper($result['hits']);
        $suggests = $result['options'];
        return response()->json(compact(['items', 'suggests']));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getInput(Request $request): mixed
    {
        return trim($request->input('keyword'));
    }
}
