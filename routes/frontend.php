<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'localization'], function () {
    Route::any('/{any}', function () {
        return view('frontend.app');
    })
        ->where('any', '.*');

});
