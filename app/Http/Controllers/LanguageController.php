<?php

namespace App\Http\Controllers;


use App\Traits\HttpResponses;
use Illuminate\Http\Request;


class LanguageController extends Controller
{
    use HttpResponses;

    public function changeLanguage(Request $request, $lang = 'en')
    {
        $languageArray = array_map(function ($item) {
            return $item['title'];
        }, config('lang'));
        if (in_array($lang, array_keys($languageArray))) {
            setcookie('locale', $lang, time() + 31536000, "/"); // 31536000 = 1 year
        }
        if ($request->wantsJson() || $request->ajax()) {
            return $this->success([]);
        }
        return back();
    }
}
