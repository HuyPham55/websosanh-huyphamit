<?php

use App\Http\Controllers\Backend\BannerController;
use App\Http\Controllers\Backend\BlogCategoryController;
use App\Http\Controllers\Backend\BlogPostController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {


    //Only uncomment if config/lfm->use_package_routes set to false
    /*
    Route::group(['prefix' => 'laravel-filemanager'], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });
    */

    Route::get('dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

    //Settings
    Route::group(['prefix' => 'settings'], function () {
        //Banners
        Route::group(['prefix' => 'banner'], function () {
            Route::group(['middleware' => 'can:change_banners'], function () {
                Route::get('/', [BannerController::class, 'getEdit'])->name('settings.banner');
                Route::put('/', [BannerController::class, 'putEdit']);
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
            Route::put('edit/{id}', [UserController::class, 'postEdit'])
                ->where(['id' => '[0-9]+']);
        });
        Route::get('edit-profile', [UserController::class, 'getEditProfile'])->name('users.edit_profile');
        Route::put('edit-profile', [UserController::class, 'postEditProfile']);
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
            Route::put('edit/{id}', [RoleController::class, 'postEdit'])
                ->where(['id' => '[0-9]+']);
        });
        Route::post('delete', [RoleController::class, 'delete'])->middleware('can:delete_roles')->name('role.delete');
    });

    //Blog
    Route::group(['prefix' => 'blog'], function () {
        //Blog Category
        Route::group(['prefix' => 'categories'], function () {
            Route::get('/', [BlogCategoryController::class, 'index'])->middleware('permission:show_list_blog_categories')->name('blog_categories.list');
            Route::group(['middleware' => 'permission:add_blog_categories'], function () {
                Route::get('add', [BlogCategoryController::class, 'getAdd'])->name('blog_categories.add');
                Route::post('add', [BlogCategoryController::class, 'postAdd']);
            });
            Route::group(['middleware' => 'permission:edit_blog_categories'], function () {
                Route::get('edit/{id}', [BlogCategoryController::class, 'getEdit'])->name('blog_categories.edit');
                Route::put('edit/{id}', [BlogCategoryController::class, 'putEdit']);

                Route::post('change-sorting', [BlogCategoryController::class, 'changeSorting'])->name('blog_categories.change_sorting');
                Route::post('change-status', [BlogCategoryController::class, 'changeStatus'])->name('blog_categories.change_status');
            });
            Route::post('delete', [BlogCategoryController::class, 'delete'])->middleware('permission:delete_blog_categories')->name('blog_categories.delete');
        });

        //Blog Posts
        Route::group(['prefix' => 'posts'], function () {
            Route::get('/', [BlogPostController::class, 'index'])->middleware('permission:show_list_blog_posts')->name('blog_posts.list');
            Route::get('/datatables', [BlogPostController::class, 'datatables'])->middleware('permission:show_list_blog_posts')->name('blog_posts.datatables');

            Route::group(['middleware' => 'permission:add_blog_posts'], function () {
                Route::get('add', [BlogPostController::class, 'getAdd'])->name('blog_posts.add');
                Route::post('add', [BlogPostController::class, 'postAdd']);
            });
            Route::group(['middleware' => 'permission:edit_blog_posts'], function () {
                Route::get('edit/{id}', [BlogPostController::class, 'getEdit'])->name('blog_posts.edit');
                Route::put('edit/{id}', [BlogPostController::class, 'putEdit']);

                Route::post('change-popular', [BlogPostController::class, 'changePopular'])->name('blog_posts.change_popular');
                Route::post('change-status', [BlogPostController::class, 'changeStatus'])->name('blog_posts.change_status');
                Route::post('change-sorting', [BlogPostController::class, 'changeSorting'])->name('blog_posts.change_sorting');
            });
            Route::post('delete', [BlogPostController::class, 'delete'])->middleware('permission:delete_blog_posts')->name('blog_posts.delete');
        });
    });

});
