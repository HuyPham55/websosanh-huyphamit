<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Spatie\Translatable\HasTranslations;

/**
 * @property mixed $category_id
 * @property int|mixed $sorting
 * @property bool|mixed $is_popular
 * @property bool|mixed $status
 * @property mixed $created_at
 * @property \Illuminate\Support\Carbon|mixed|null $publish_date
 */
class BlogPost extends BaseModel
{
    use HasFactory;
    use HasTranslations;
    use Filterable;



    public array $translatable = [
        'image',
        'title',
        'slug',
        'content',
        'short_description',
        'seo_title',
        'seo_description',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    public static function saveModel(self $model, Request $request)
    {
        DB::beginTransaction();
        try {
            foreach (config('lang') as $langKey => $langTitle) {
                $title = trim($request->input("$langKey.title"));
                $slug = simple_slug($title);

                $model->setTranslation('image', $langKey, $request->input("$langKey.image"));
                $model->setTranslation('title', $langKey, $title);
                $model->setTranslation('slug', $langKey, !empty($slug) ? $slug : 'post-detail');
                $model->setTranslation('content', $langKey, $request->input("$langKey.content"));
                $model->setTranslation('short_description', $langKey, $request->input("$langKey.short_description"));

                $model->setTranslation('seo_title', $langKey, $request->input("$langKey.seo_title"));
                $model->setTranslation('seo_description', $langKey, $request->input("$langKey.seo_description"));
            }
            $model->category_id = $request->input('category', 0);
            $model->sorting = $request->input('sorting') | 0;

            $model->is_popular = $request->boolean('is_popular', true);

            $model->publish_date = $request->date('publish_date', 'Y-m-d');

            $model->status = $request->boolean('status', true);
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
        return $this->created_at ? date_format($this->created_at, 'Y-m-d') : null;
    }

    public function getPublishFormatAttribute()
    {
        return $this->publish_date ? date_format(Carbon::parse($this->publish_date), 'Y-m-d') : null;
    }
}
