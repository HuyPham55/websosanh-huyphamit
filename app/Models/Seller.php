<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * @property mixed $image
 * @property mixed $banner
 * @property mixed $icon
 * @property mixed|string $title
 * @property array|mixed|string $slug
 * @property bool|mixed $status
 * @property bool|mixed $featured
 * @property bool|mixed $recommended
 * @property int|mixed $sorting
 * @property mixed $url
 */
class Seller extends BaseModel
{
    use HasFactory;
    use Filterable;

    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function comparisons()
    {
        return $this->belongsToMany(Comparison::class);
    }

    public static function saveModel(self $model, Request $request)
    {
        DB::beginTransaction();
        try {
            foreach (config('lang') as $langKey => $langTitle) {
                $title = trim($request->input("$langKey.title"));
                $slug = simple_slug($title);

                $model->image = $request->input("$langKey.image");
                $model->banner = $request->input("$langKey.banner");
                $model->icon = $request->input("$langKey.icon");
                $model->title = $title;
                $model->slug = !empty($slug) ? $slug : 'post-detail';
            }
            $model->sorting = $request->input('sorting') | 0;

            $model->featured = $request->boolean('featured', true);
            $model->recommended = $request->boolean('recommended', true);
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
}
