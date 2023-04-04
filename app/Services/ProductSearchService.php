<?php

namespace App\Services;

use App\Models\Product;

class ProductSearchService
{
    protected ElasticService $service;

    public function __construct()
    {
        $this->service = (new ElasticService((new Product())->getTable()));
    }

    public function productsByCategory(array $categories, $page = 0, $minPrice = 0, $maxPrice = 0, $sorting = null, $seller = 0)
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

    public function productMapper($array)
    {
        $callback = function ($item) {
            return $item["_source"];
        };
        return array_map(
            $callback
            , $array
        );
    }

    public function productByKeyword($keyword, array $categories = [], $page = 0, $minPrice = 0, $maxPrice = 0, $sorting = null, $seller = 0) {
        $minPrice = $minPrice | 0;
        $maxPrice = $maxPrice | 0;
        $sort = $this->validateSort($sorting);
        $query = [
            'bool' => [
                'must' => [
                    ['match' => ['title' => ['query' => $keyword, 'fuzziness'=> 'AUTO']]],
                ],
                'should' => [
                    ['match' => ['slug' => $keyword]],
                    ['match' => ['image' => $keyword]],
                ],
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
        $result = $this->service->search($query, 40, $fields, $page, $sort);
        return $result;
    }

    /**
     * @param mixed $sorting
     * @return array
     */
    public function validateSort(mixed $sorting): array
    {
        $sortOptions = ["_score-asc", "price-asc", "price-desc", "hits-desc"];
        $sort = [];
        if ($sorting !== null && in_array($sorting, $sortOptions)) {
            $explode = explode("-", $sorting);
            $sort = [$explode[0] => $explode[1]];
        }
        return $sort;
    }
}
