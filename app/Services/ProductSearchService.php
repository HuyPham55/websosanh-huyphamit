<?php

namespace App\Services;

use App\Models\Comparison;
use App\Models\Product;

class ProductSearchService
{
    protected ElasticService $service;

    public function __construct()
    {
        $this->service = (new ElasticService([(new Product())->getTable(), (new Comparison())->getTable()]));
    }

    public function itemsByCategory(array $categories, $page = 0, $minPrice = 0, $maxPrice = 0, $sorting = null, $seller = 0)
    {
        $minPrice = $minPrice | 0;
        $maxPrice = $maxPrice | 0;
        $sort = $this->validateSort($sorting);
        $query = [
            'bool' => [
                'filter' => [
                    ['term' => ['status' => 1]],
                    ['terms' => ['product_category_id' => $categories]],
                ]
            ],
        ];
        $fields = ['id', 'title', 'slug', 'price', 'original_price', 'image', 'featured', 'seller_image'];
        if (($minPrice || $maxPrice) && ($minPrice <= $maxPrice)) {
            $query['bool']['filter'][] = ['range' => ['price' => ['gte' => $minPrice, 'lte' => $maxPrice]]];
        }

        if ($seller !== 0) {
            $query['bool']['filter'][] = ['term' => ['seller_id' => $seller]];
        }
        $result = $this->service->search($query, 40, $fields, $page, $sort);
        return $result;
    }

    public function resultMapper($array)
    {
        $callback = function ($item) {
            $result = $item["_source"];
            $result['index'] = $item['_index'];
            return $result;
        };
        return array_map(
            $callback
            , $array
        );
    }

    public function searchByKeyword($keyword, array $categories = [], $page = 0, $minPrice = 0, $maxPrice = 0, $sorting = null, $seller = 0) {
        $minPrice = $minPrice | 0;
        $maxPrice = $maxPrice | 0;
        $sort = $this->validateSort($sorting);
        $query = [
            'bool' => [
                'should' => [
                    ['match' => ['title' => ['query' => $keyword, 'fuzziness'=> 'AUTO']]],
                    ['match' => ['slug' => $keyword]],
                    ['match' => ['image' => $keyword]],
                ],
                "minimum_should_match" => 1,
                'filter' => [
                    ['term' => ['status' => 1]],
                ]
            ],
        ];
        $fields = ['id', 'title', 'slug', 'price', 'original_price', 'image', 'featured', 'seller_image'];
        if (($minPrice || $maxPrice) && ($minPrice <= $maxPrice)) {
            $query['bool']['filter'][] = ['range' => ['price' => ['gte' => $minPrice, 'lte' => $maxPrice]]];
        }

        if (!empty($categories)) {
            $query['bool']['field'][] = ['terms' => ['product_category_id' => $categories]];
        }
        if ($seller !== 0) {
            $query['bool']['filter'][] = ['term' => ['seller_id' => $seller]];
        }
        return $this->service->search($query, 40, $fields, $page, $sort);
    }

    /**
     * @param mixed $sorting
     * @return array
     */
    public function validateSort(mixed $sorting): array
    {
        $sortOptions = ["_score-desc", "price-asc", "price-desc", "hits-desc", "sorting-asc"];
        $sort = [];
        if ($sorting !== null && in_array($sorting, $sortOptions)) {
            $explode = explode("-", $sorting);
            $sort = [$explode[0] => $explode[1]];
        }
        return $sort;
    }
}
