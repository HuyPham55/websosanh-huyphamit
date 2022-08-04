<?php

use App\Http\Controllers\Backend\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
    Route::get('dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

    //User
    Route::group(['prefix' => 'users'], function () {
        Route::get('list', [UserController::class, 'getList'])->middleware('can:show_list_users')->name('users.list');
        Route::group(['middleware' => 'can:add_users'], function () {
            Route::get('add', [UserController::class, 'getAdd'])->name('users.add');
            Route::post('add', [UserController::class, 'postAdd']);
        });
        Route::group(['middleware' => 'can:edit_users'], function () {
            Route::get('edit/{id}', [UserController::class, 'getEdit'])->name('users.edit')
                ->where(['id' => '[0-9]+']);
            Route::post('edit/{id}', [UserController::class, 'postEdit'])
                ->where(['id' => '[0-9]+']);
        });
        Route::get('edit-profile', [UserController::class, 'getEditProfile'])->name('users.edit_profile');
        Route::post('edit-profile', [UserController::class, 'postEditProfile']);
        Route::get('change-password', [UserController::class, 'getChangePassword'])->name('users.change_password');
        Route::post('change-password', [UserController::class, 'postChangePassword']);

        Route::post('delete', [UserController::class, 'delete'])->middleware('can:delete_users')->name('users.delete');
    });

});
