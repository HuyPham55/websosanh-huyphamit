<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Translatable\HasTranslations;

/**
 * @property int|mixed $sorting
 * @property bool|mixed $status
 */
class Faq extends BaseModel
{
    use HasFactory;
    use HasFactory;
    use HasTranslations;
    use Filterable;

    public array $translatable = [
        'title',
        'content',
    ];
    public static function saveModel(self $model, Request $request)
    {
        DB::beginTransaction();
        try {
            foreach (config('lang') as $langKey => $langTitle) {
                $title = trim($request->input("$langKey.title"));
                $model->setTranslation('title', $langKey, $title);
                $model->setTranslation('content', $langKey, $request->input("$langKey.content"));
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
