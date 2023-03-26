<?php

namespace App\Models;

use App\Observers\ScrapeObserver;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

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
            $model->seller_id = $request->input('seller') | 0;
            $model->product_category_id = $request->input('category') | 0;

            $products = $request->input('products') ?? [];

            $model->result = json_encode($products);
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
            $model->children = array_values($children) ?? [];
            $model->save();
            $productData = [];
            foreach ($products as $item) {
                $productData[] = [
                    'id' => $item['id'],
                    'product_category_id' => $model->product_category_id,
                    'title' => $item['title'],
                    'slug' => simple_slug($item['title']),
                    'image' => $item['image'],
                    'url' => $item['url'],
                    'price' => (int)preg_replace("/[^0-9]/", '', $item['price']),
                    'original_price' => (int)preg_replace("/[^0-9]/", '', $item['original_price']),
                    'seller_id' => $model->seller_id,
                ];
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
                        $product = new Product($newItemData);
                        $model->products()->save($product);
                    } else {
                        $product->update($itemData);
                    }
                } else {
                    $product = new Product($newItemData);
                    $model->products()->save($product);
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
