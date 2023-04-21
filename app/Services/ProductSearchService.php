<?php

namespace App\Services;

use App\Models\Comparison;
use App\Models\Product;

class ProductSearchService
{
    protected ElasticService $service;

    public function __construct(array $index = [])
    {
        $productIndex = (new Product())->getTable();
        $comparisonIndex = (new Comparison())->getTable();
        if (empty($index)) {
            $index = [$productIndex, $comparisonIndex];
        }
        $this->service = (new ElasticService([$comparisonIndex, $productIndex]));
        foreach ($index as $item) {
            if (!$this->service->indexExist($item)) {
                $this->service->createIndex($item);
            }
        }
    }

    public function itemsByCategory(
        array $categories,
              $page = 1,
              $minPrice = 0,
              $maxPrice = 0,
              $sorting = null,
              $seller = 0,
        int   $perPage = 40,
        bool  $useScore = true
    )
    {
        $minPrice = $minPrice | 0;
        $maxPrice = $maxPrice | 0;
        $page = $this->getPageNumber($page);
        $sort = $this->validateSort($sorting);
        $filter = [
            ['term' => ['status' => 1]],
            ['terms' => ['product_category_id' => $categories]],
        ];
        if (($minPrice || $maxPrice) && ($minPrice <= $maxPrice)) {
            $filter[] = ['range' => ['price' => ['gte' => $minPrice, 'lte' => $maxPrice]]];
        }
        if ($seller !== 0) {
            $filter[] = ['term' => ['seller_id' => $seller]];
        }
        $query = [
            'function_score' => [
                'query' => [
                    'bool' => [
                        'filter' => $filter
                    ],
                ],
                'functions' => [
                ],
                'boost_mode' => 'sum',
            ]
        ];
        if ($useScore) {
            $query['function_score']['functions'][] = [
                'filter' => [
                    ['term' => ['featured' => 1]]
                ],
                'weight' => 2
            ];
        }
        $fields = ['id', 'title', 'slug', 'price', 'original_price', 'image', 'featured', 'seller_image'];
        return $this->service->search($query, $perPage, $fields, $page, $sort);
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

    public function searchByKeyword(
        $keyword,
        array $categories = [],
        $page = 1,
        $minPrice = 0,
        $maxPrice = 0,
        $sorting = null,
        $seller = 0,
        bool $useScore = true
    )
    {
        $minPrice = $minPrice | 0;
        $maxPrice = $maxPrice | 0;
        $page = $this->getPageNumber($page);
        $sort = $this->validateSort($sorting);


        $filter = [
            ['term' => ['status' => 1]],
        ];

        if (($minPrice || $maxPrice) && ($minPrice <= $maxPrice)) {
            $filter[] = ['range' => ['price' => ['gte' => $minPrice, 'lte' => $maxPrice]]];
        }

        if ($seller !== 0) {
            $filter[] = ['term' => ['seller_id' => $seller]];
        }

        if (!empty($categories)) {
            $filter[] = ['terms' => ['product_category_id' => $categories]];
        }

        $query = [
            'function_score' => [
                'query' => [
                    'bool' => [
                        'must' => [
                            ['multi_match' =>
                                [
                                    'query' => $keyword,
                                    'fuzziness' => 'AUTO',
                                    'fields' => ['title^2', 'slug', 'image'],
                                ],

                            ]
                        ],
                        'filter' => $filter
                    ],
                ],
                'boost_mode' => 'multiply',
            ]
        ];

        $fallbackQuery = [
            'should' => [
                ['match' => ['title' => ['query' => $keyword, 'fuzziness' => 'AUTO']]],
                ['match' => ['slug' => $keyword]],
                ['match' => ['image' => $keyword]],
            ],
            "minimum_should_match" => 1,
        ];

        if ($useScore) {
            $query['function_score']['functions'][] = [
                'filter' => [
                    ['term' => ['featured' => 1]]
                ],
                'weight' => 1.5
            ];
        }
        $fields = ['id', 'title', 'slug', 'price', 'original_price', 'image', 'featured', 'seller_image'];
        return $this->service->search($query, 40, $fields, $page, $sort);
    }

    public function suggestByKeyword(string $keyword)
    {
        $query = [
            'keyword' => [
                'text' => $keyword,
                'term' => [
                    'field' => 'title',
                ]
            ]
        ];
        $searchQuery = [
            'bool' => [
                'should' => [
                    ['match' => ['title' => ['query' => $keyword, 'fuzziness' => 'AUTO']]],
                ],
                "minimum_should_match" => 1,
                'filter' => [
                    ['term' => ['status' => 1]],
                ]
            ],
        ];
        $fields = ['id', 'title', 'slug', 'price', 'original_price', 'image'];
        $response = $this->service->suggest($query, $searchQuery, $fields);
        $options = $response['suggest']['keyword'][0]['options'];
        $options = array_map(function ($item) {
            return $item['text'];
        }, $options);
        $hits = $response['hits'];
        return compact('options', 'hits');
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

    /**
     * @param mixed $page
     * @return int
     */
    public function getPageNumber(mixed $page): int
    {
        //page is display number, starting from 1
        return ($page | 0) - 1;
        //page is now index number, starting from 0
    }
}
