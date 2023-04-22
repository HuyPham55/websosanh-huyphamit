<?php

namespace App\Models;

use App\Observers\ComparisonObserver;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * @property int|mixed $sorting
 * @property int|mixed $price
 * @property bool|mixed $featured
 * @property bool|mixed $status
 * @property mixed $image
 * @property mixed|string $title
 * @property mixed $product_category_id
 * @property array|mixed|string $slug
 * @property mixed $content
 * @property mixed $seo_title
 * @property mixed $seo_description
 */
class Comparison extends BaseModel
{
    use HasFactory;
    use Filterable;
    protected $casts = [
        'featured' => 'integer',
        'is_popular' => 'integer',
        'status' => 'integer',
        'slide' => 'array',
    ];

    public static function boot()
    {
        parent::boot();
        self::observe(ComparisonObserver::class);
    }
    public function products()
    {
        //A comparison is composed of many products
        return $this->belongsToMany(Product::class);
    }

    public function productCategory()
    {
        //Used for filter by product category
        return $this->belongsTo(ProductCategory::class);
    }

    protected $guarded = [];
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
                $model->content = $request->input("$langKey.content");
                $model->seo_title = $request->input("$langKey.seo_title");
                $model->seo_description = $request->input("$langKey.seo_description");
            }
            $model->product_category_id = $request->input('category', 0);
            $model->sorting = $request->input('sorting') | 0;
            $model->price = $request->integer('price') | 0;

            $model->featured = $request->boolean('featured', true);
            $model->status = $request->boolean('status', true);


            $model->slide = $request->input('slides');
            $model->save();
            DB::commit();
            return $model;
        } catch (\Exception $exception) {
            DB::rollback();
            if (env('APP_ENV') !== 'production') {
                throw $exception;
            }
            return $exception;
        }
    }

    public function getDateFormatAttribute()
    {
        return $this->date;
    }
}
