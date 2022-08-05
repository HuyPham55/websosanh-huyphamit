<?php

use App\Http\Controllers\Backend\BannerController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
    Route::get('dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

    //Settings
    Route::group(['prefix' => 'settings'], function () {
        //Banners
        Route::group(['prefix' => 'banner'], function () {
            Route::group(['middleware' => 'can:change_banners'], function () {
                Route::get('/', [BannerController::class, 'getEdit'])->name('settings.banner');
                Route::post('/', [BannerController::class, 'postEdit']);
            });
        });
    });

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

    //Roles
    Route::group(['prefix' => 'role'], function () {
        Route::get('list', [RoleController::class, 'index'])->middleware('can:show_list_roles')->name('role.list');
        Route::group(['middleware' => 'can:add_roles'], function () {
            Route::get('add', [RoleController::class, 'getAdd'])->name('role.add');
            Route::post('add', [RoleController::class, 'postAdd']);
        });
        Route::group(['middleware' => 'can:edit_roles'], function () {
            Route::get('edit/{id}', [RoleController::class, 'getEdit'])->name('role.edit')
                ->where(['id' => '[0-9]+']);
            Route::post('edit/{id}', [RoleController::class, 'postEdit'])
                ->where(['id' => '[0-9]+']);
        });
        Route::post('delete', [RoleController::class, 'delete'])->middleware('can:delete_roles')->name('role.delete');
    });

});
