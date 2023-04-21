<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ''], function () {
    Route::any('/{any}', function () {
        return view('frontend.app');
    })
        ->where('any', '.*');
});
