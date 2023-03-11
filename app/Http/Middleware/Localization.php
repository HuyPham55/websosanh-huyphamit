<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (isset($_COOKIE['locale']) && in_array($_COOKIE['locale'], array_keys(config('lang')))) {
            App::setLocale($_COOKIE['locale']);
        } else {
            $defaultLocale = config('app.locale');

            App::setLocale($defaultLocale);
            setcookie('locale', $defaultLocale, time() + 31536000, "/"); // 31536000 = 1 year
        }
        return $next($request);
    }
}
