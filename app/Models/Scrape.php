<?php

namespace App\Models;

use App\Observers\ScrapeObserver;
use App\Services\CategoryService;
use App\Services\ScrapeService;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Exception\NotFoundException;

/**
 * @property mixed $date
 * @property mixed $url
 * @property int|mixed $seller_id
 * @property int|mixed $product_category_id
 * @property false|mixed|string $result
 * @property false|mixed|string $data
 * @property false|mixed|string $children
 */
class Scrape extends BaseModel
{
    use HasFactory;
    use Filterable;


    protected $casts = [
        'url' => 'encrypted',
    ];

    public static function boot()
    {
        parent::boot();
        self::observe(ScrapeObserver::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }


    public static function createProduct(array $newItemData, Scrape $model)
    {
        if (Product::where('url', $newItemData['url'])->get()->first() !== null) {
            //duplicated Product['url'] -> skip
            return false;
        }
        $product = new Product($newItemData);
        $model->products()->save($product);
        return $product;
    }

    /**
     * @param $price
     * @return int
     */
    public static function extractPrice($price): int
    {
        return (int)preg_replace("/[^0-9]/", '', $price);
    }

    public function seller()
    {
        //Determine seller of the scrape, can NOT be null
        return $this->belongsTo(Seller::class);
    }

    public function getDateFormatAttribute()
    {
        return $this->date;
    }

    public static function saveModel(self $model, Request $request, $editFlag)
    {
        DB::beginTransaction();
        try {
            $model->url = $request->input('url_seed', 0);
            $seller_id = $request->input('seller') | 0;
            $model->seller_id = $seller_id;
            $product_category_id = $request->input('category') | 0;
            $model->product_category_id = $product_category_id;

            $seller = Seller::find($seller_id);
            $category = ProductCategory::find($product_category_id);
            if ($seller == null || $category == null) {
                throw new NotFoundException();
            }
            $categoryService = (new CategoryService(new ProductCategory()));
            $arrayParentCategories = $categoryService
                ->getArrayParentId($category->lft | 0, $category->rgt | 0) ?? [];
            foreach ($arrayParentCategories as $item) {
                $seller->productCategories()->syncWithoutDetaching($item);
            }

            $products = $request->input('products') ?? [];
            $result = [
                'products' => array_values($products) ?? []
            ];
            $model->result = json_encode($result);
            $data = [
                'sample' => [
                    'title' => $request->input('title'),
                    'image' => $request->input('image'),
                    'url' => $request->input('url'),
                    'price' => $request->input('price'),
                    'original_price' => $request->input('original_price'),
                ],
                'htmlTextContent' => $request->input('htmlTextContent'),
                'htmlContent' => $request->input('htmlContent'),
                'queryData' => $request->input('queryData'),
            ];
            $model->data = json_encode($data) ?? [];


            $children = $request->input('children') ?? [];
            $model->children = json_encode(array_values($children) ?? []);
            $model->save();
            $productData = [];

            $scrapeService = new ScrapeService();

            foreach ($products as $item) {
                $custom = [
                    'featured' => 0,
                ];
                $productData[] = array_merge(
                    [
                        'id' => $item['id'] | 0,
                        'product_category_id' => $model->product_category_id,
                        'title' => $item['title'],
                        'slug' => simple_slug($item['title']),
                        'image' => $scrapeService->saveImage($item['image'], $model->id),
                        'url' => $item['url'],
                        'price' => self::extractPrice($item['price']),
                        'original_price' => self::extractPrice($item['original_price']),
                        'seller_id' => $model->seller_id | 0,
                    ],
                    $custom);
            }
            $arrayItemId = array_map(function ($item) {
                return $item['id'];
            }, $productData);
            foreach ($model->products()->whereNotIn('id', $arrayItemId)->get() as $item) {
                $item->delete();
            }
            foreach ($productData as $itemData) {
                $newItemData = Arr::except($itemData, ['id']);

                if ($editFlag) {
                    $product = Product::find($itemData['id']);
                    if ($product == null) {
                        self::createProduct($newItemData, $model);
                    } else {
                        $product->update(Arr::except($itemData, ['featured']));
                    }
                } else {
                    self::createProduct($newItemData, $model);
                }
            }
            DB::commit();
            return $model;
        } catch (\Exception $exception) {
            DB::rollback();
            return $exception;
        }
    }


}
