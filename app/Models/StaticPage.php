<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Translatable\HasTranslations;

/**
 * @property int|mixed $sorting
 * @property bool|mixed $status
 */
class StaticPage extends BaseModel
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = [
        'key'
    ];

    public array $translatable = [
        'image',
        'title',
        'slug',
        'content',
        'seo_title',
        'seo_description',
    ];

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

                $model->setTranslation('seo_title', $langKey, $request->input("$langKey.seo_title"));
                $model->setTranslation('seo_description', $langKey, $request->input("$langKey.seo_description"));
            }
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
}
