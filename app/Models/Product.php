<?php

namespace App\Models;

use App\Observers\ProductObserver;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * @property mixed $product_category_id
 * @property int|mixed $sorting
 * @property int|mixed $price
 * @property bool|mixed $featured
 * @property bool|mixed $is_popular
 * @property bool|mixed $status
 *
 * @property mixed $image
 * @property mixed|string $title
 * @property array|mixed|string $slug
 * @property bool|mixed $url
 * @property mixed $created_at
 * @property int|mixed $original_price
 * @property mixed $id
 */
class Product extends BaseModel
{
    use HasFactory;
    use Filterable;
    protected $casts = [
        'featured' => 'integer',
        'is_popular' => 'integer',
        'status' => 'integer',
    ];
    protected $guarded = [];
    public static function boot()
    {
        parent::boot();
        self::observe(ProductObserver::class);
    }
    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function comparison()
    {
        //Determine comparisons in which this product appears
        return $this->belongsToMany(Comparison::class);
    }

    public function seller()
    {
        //Determine seller of the product, can NOT be null
        return $this->belongsTo(Seller::class);
        //seller_image
    }

    public function scape()
    {
        //Determine scape of the product, can be null
        return $this->belongsTo(Scrape::class);
    }

    public static function saveModel(self $model, Request $request)
    {
        DB::beginTransaction();
        try {
            foreach (config('lang') as $langKey => $langTitle) {
                $title = trim($request->input("$langKey.title"));
                $slug = simple_slug($title);

                $model->image = $request->input("$langKey.image");
                $model->title = $title;
                $model->slug = !empty($slug) ? $slug : 'post-detail';
            }
            $model->product_category_id = $request->input('category', 0);
            $model->sorting = $request->input('sorting') | 0;
            $model->price = $request->integer('sorting') | 0;
            $model->original_price = $request->integer('original_price') | 0;

            $model->featured = $request->boolean('featured', true);
            $model->is_popular = $request->boolean('is_popular', true);
            $model->status = $request->boolean('status', true);

            $model->url = $request->input('url');
            $model->save();
            DB::commit();
            return $model;
        } catch (\Exception $exception) {
            DB::rollback();
            return $exception;
        }
    }
    public function getDateFormatAttribute()
    {
        return date_format($this->created_at, 'Y/m/d');
    }
    protected $appends = ['seller_image'];
    protected function sellerImage(): Attribute
    {
        return Attribute::make(
          get: fn() => $this->seller->image
        );
    }
}
