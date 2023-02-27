<?php

namespace App\Models;

use App\Observers\BlogCategoryObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Translatable\HasTranslations;

/**
 * @property mixed $parent_id
 * @property int|mixed $sorting
 * @property bool|mixed $status
 */
class BlogCategory extends BaseModel
{
    use HasFactory;
    use HasTranslations;

    public array $translatable = [
        'image',
        'title',
        'slug',
        'seo_title',
        'seo_description',
    ];

    public static function boot()
    {
        parent::boot();
        self::observe(BlogCategoryObserver::class);
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
                $model->setTranslation('seo_title', $langKey, $request->input("$langKey.seo_title"));
                $model->setTranslation('seo_description', $langKey, $request->input("$langKey.seo_description"));
            }
            $model->parent_id = $request->input('parent_category', 0);
            $model->sorting = $request->input('sorting') | 0;
            $model->status = $request->boolean('status', true);
            $model->save();
            DB::commit();
            return $model;
        } catch (\Exception $exception) {
            DB::rollback();
            return false;
        }
    }

    public function posts(): HasMany
    {
        return $this
            ->hasMany(BlogPost::class, 'category_id')
            ->orderBy('sorting')
            ->orderBy('id');
    }
}
