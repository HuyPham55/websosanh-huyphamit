<?php

namespace App\Http\Controllers\Backend;

use App\Enums\CommonStatus;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class BaseController extends Controller
{
    //
    public array $lang;

    public function __construct()
    {

        $this->lang = array_map(function($item) { return $item['title']; }, config('lang'));
        $this->middleware(function ($request, $next) {
            View::share([
                'status' => $this->getStatus(),
                'lang' => $this->lang,
            ]);
            return $next($request);
        });
    }

    private function getStatus(): array
    {
        return [
            CommonStatus::Active => trans('label.status.active'),
            CommonStatus::Inactive => trans('label.status.inactive'),
        ];
    }

}
