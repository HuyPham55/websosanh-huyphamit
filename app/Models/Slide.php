<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Translatable\HasTranslations;

/**
 * @property mixed $key
 * @property int|mixed $sorting
 * @property bool|mixed $status
 * @property mixed $created_at
 */
class Slide extends BaseModel
{
    use HasFactory;
    use HasTranslations;
    public array $translatable = [
        'image',
        'url',
        'text_1',
        'text_2',
        'text_3',
        'description',
    ];

    public static function saveModel(self $model, string $key, Request $request)
    {
        DB::beginTransaction();
        try {
            foreach (config('lang') as $langKey => $langTitle) {
                $model->setTranslation('image', $langKey, $request->input("$langKey.image"));
                $model->setTranslation('url', $langKey, $request->input("$langKey.url"));
                $model->setTranslation('text_1', $langKey, $request->input("$langKey.text_1"));
                $model->setTranslation('text_2', $langKey, $request->input("$langKey.text_2"));
                $model->setTranslation('text_3', $langKey, $request->input("$langKey.text_3"));
                $model->setTranslation('description', $langKey, $request->input("$langKey.description"));
            }

            $model->key = $key;
            $model->sorting = $request->input('sorting') | 0;
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
        return date_format($this->created_at, 'Y/m/d');
    }
}
