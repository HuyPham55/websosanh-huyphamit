<?php

namespace App\Http\Requests;

use App\Models\Scrape;
use App\Rules\ValidateUniqueEncrypted;
use Illuminate\Foundation\Http\FormRequest;

class ScrapeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->guard('web')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
            'url' => [new ValidateUniqueEncrypted(new Scrape(), 'url', $this->id)]
        ];
    }
}
