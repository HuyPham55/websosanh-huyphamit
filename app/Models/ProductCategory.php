<?php

namespace App\Models;

use App\Observers\ProductCategoryObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * @property int|mixed $sorting
 * @property bool|mixed $featured
 * @property bool|mixed $status
 * @property bool|mixed $is_shown_on_menu
 * @property bool|mixed $is_popular
 * @property mixed $image
 * @property mixed $icon
 * @property mixed $banner
 * @property mixed|string $title
 * @property array|mixed|string $slug
 * @property mixed $seo_title
 * @property mixed $seo_description
 * @property mixed $parent_id
 * @property mixed $content
 */
class ProductCategory extends BaseModel
{
    use HasFactory;

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();
        self::observe(ProductCategoryObserver::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function comparisons() {
        //Used for filter by product category
        return $this->hasMany(Comparison::class);
    }

    public function sellers()
    {
        //Used for filter
        return $this->belongsToMany(Seller::class);
    }

    public function children(): HasMany
    {
        return $this->hasMany(ProductCategory::class, 'parent_id');
    }

    public static function saveModel(self $model, Request $request)
    {
        DB::beginTransaction();
        try {
            foreach (config('lang') as $langKey => $langTitle) {
                $title = trim($request->input("$langKey.title"));
                $slug = simple_slug($title);

                $model->image = $request->input("$langKey.image");
                $model->icon = $request->input("$langKey.icon");
                $model->banner = $request->input("$langKey.banner");
                $model->title = $title;
                $model->slug = !empty($slug) ? $slug : 'post-detail';
                $model->content = $request->input("$langKey.content");
                $model->seo_title = $request->input("$langKey.seo_title");
                $model->seo_description = $request->input("$langKey.seo_description");
            }
            $model->parent_id = $request->input('parent_category', 0);
            $model->sorting = $request->input('sorting') | 0;
            $model->status = $request->boolean('status', true);
            $model->featured = $request->boolean('featured', true);
            $model->is_shown_on_menu = $request->boolean('is_shown_on_menu', true);
            $model->is_popular = $request->boolean('is_popular', true);
            $model->save();
            DB::commit();
            return $model;
        } catch (\Exception $exception) {
            DB::rollback();
            return false;
        }
    }

}
