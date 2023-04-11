<?php

use App\Http\Controllers\Frontend\ContactController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'localization'], function () {
    //Contact
    Route::group(['prefix' => 'contact'], function () {
        Route::post('/', [ContactController::class, 'postContact'])->name('contact.post');
        Route::post('/refresh-captcha', [ContactController::class, 'refreshCaptcha'])->name('contact.refresh_captcha');
    });
});
