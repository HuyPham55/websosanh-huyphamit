<?php

use App\Http\Controllers\Backend\BannerController;
use App\Http\Controllers\Backend\BlogCategoryController;
use App\Http\Controllers\Backend\BlogPostController;
use App\Http\Controllers\Backend\ComparisonController;
use App\Http\Controllers\Backend\ContactController;
use App\Http\Controllers\Backend\FaqController;
use App\Http\Controllers\Backend\HomeSlideController;
use App\Http\Controllers\Backend\MemberController;
use App\Http\Controllers\Backend\OptionController;
use App\Http\Controllers\Backend\ProductCategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\ScrapeController;
use App\Http\Controllers\Backend\SellerController;
use App\Http\Controllers\Backend\StaticPageController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\FooterSlideController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'middleware' => ['auth:web']], function () {


    /*
        Only uncomment if config/lfm->use_package_routes set to false
        Also affect rich text editors
    */
    Route::group(['prefix' => 'laravel-filemanager'], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });

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

        //Options
        Route::group(['prefix' => 'options'], function () {
            Route::group(['middleware' => 'permission:change_website_settings'], function () {
                Route::get('/', [OptionController::class, 'getEdit'])->name('settings.options');
                Route::put('/', [OptionController::class, 'putEdit']);
            });
        });
    });

    //Users
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
        Route::post('delete', [UserController::class, 'delete'])->middleware('can:delete_users')->name('users.delete');
    });
    //User
    Route::group(['prefix' => 'user'], function () {
        Route::get('edit-profile', [UserController::class, 'getEditProfile'])->name('users.edit_profile');
        Route::put('edit-profile', [UserController::class, 'postEditProfile']);
        Route::get('change-password', [UserController::class, 'getChangePassword'])->name('users.change_password');
        Route::post('change-password', [UserController::class, 'postChangePassword']);
    });

    //Members
    Route::group(['prefix' => 'members'], function () {
        Route::get('/', [MemberController::class, 'index'])->middleware('permission:show_list_members')->name('members.list');
        Route::group(['middleware' => 'permission:add_members'], function () {
            Route::get('add', [MemberController::class, 'getAdd'])->name('members.add');
            Route::post('add', [MemberController::class, 'postAdd']);
        });
        Route::group(['middleware' => 'permission:edit_members'], function () {
            Route::get('{id}/edit', [MemberController::class, 'getEdit'])->name('members.edit');
            Route::put('{id}/edit', [MemberController::class, 'putEdit']);
        });
        Route::post('delete', [MemberController::class, 'delete'])->middleware('permission:delete_members')->name('members.delete');
    });


    //Roles
    Route::group(['prefix' => 'role'], function () {
        Route::get('list', [RoleController::class, 'index'])->middleware('can:show_list_roles')->name('roles.list');
        Route::group(['middleware' => 'can:add_roles'], function () {
            Route::get('add', [RoleController::class, 'getAdd'])->name('roles.add');
            Route::post('add', [RoleController::class, 'postAdd']);
        });
        Route::group(['middleware' => 'can:edit_roles'], function () {
            Route::get('edit/{id}', [RoleController::class, 'getEdit'])->name('roles.edit')
                ->where(['id' => '[0-9]+']);
            Route::put('edit/{id}', [RoleController::class, 'postEdit'])
                ->where(['id' => '[0-9]+']);
        });
        Route::post('delete', [RoleController::class, 'delete'])->middleware('can:delete_roles')->name('roles.delete');
    });

    //Home slide
    Route::group(['prefix' => 'home-slides'], function () {
        Route::get('/', [HomeSlideController::class, 'index'])->middleware('permission:show_list_home_slides')->name('home_slides.list');
        Route::group(['middleware' => 'permission:add_home_slides'], function () {
            Route::get('add', [HomeSlideController::class, 'getAdd'])->name('home_slides.add');
            Route::post('add', [HomeSlideController::class, 'postAdd']);
        });
        Route::group(['middleware' => 'permission:edit_home_slides'], function () {
            Route::get('edit/{id}', [HomeSlideController::class, 'getEdit'])->name('home_slides.edit');
            Route::put('edit/{id}', [HomeSlideController::class, 'putEdit']);

            Route::post('change-sorting', [HomeSlideController::class, 'changeSorting'])->name('home_slides.change_sorting');
            Route::post('change-status', [HomeSlideController::class, 'changeStatus'])->name('home_slides.change_status');
        });
        Route::post('delete', [HomeSlideController::class, 'delete'])->middleware('permission:delete_home_slides')->name('home_slides.delete');
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

    //Static pages
    Route::group([
        'prefix' => 'static-pages',
        'middleware' => 'permission:update_home_page|update_about_page|update_blog_index|update_404_page'
    ], function () {
        $arrKey = 'home_page|about_page|blog_index|404_page';
        Route::get('/{key}', [StaticPageController::class, 'getEdit'])
            ->where('key', $arrKey)
            ->name('backend.static_page');
        Route::put('/{key}', [StaticPageController::class, 'putEdit'])
            ->where('key', $arrKey);
    });

    //Faqs
    Route::group(['prefix' => 'faqs'], function () {
        Route::get('/', [FaqController::class, 'index'])->middleware('permission:show_list_faqs')->name('faqs.list');
        Route::group(['middleware' => 'permission:add_faqs'], function () {
            Route::get('add', [FaqController::class, 'getAdd'])->name('faqs.add');
            Route::post('add', [FaqController::class, 'postAdd']);
        });
        Route::group(['middleware' => 'permission:edit_faqs'], function () {
            Route::get('edit/{id}', [FaqController::class, 'getEdit'])->name('faqs.edit');
            Route::put('edit/{id}', [FaqController::class, 'putEdit']);

            Route::post('change-sorting', [FaqController::class, 'changeSorting'])->name('faqs.change_sorting');
            Route::post('change-status', [FaqController::class, 'changeStatus'])->name('faqs.change_status');
        });
        Route::post('delete', [FaqController::class, 'delete'])->middleware('permission:delete_faqs')->name('faqs.delete');
    });

    //Contact
    Route::group(['prefix' => 'contacts'], function () {
        Route::get('/', [ContactController::class, 'index'])->middleware('permission:show_list_contacts')->name('contacts.list');
        Route::get('/show', [ContactController::class, 'show'])->name('contacts.show');
        Route::post('delete', [ContactController::class, 'delete'])->middleware('permission:delete_contacts')->name('contacts.delete');
        Route::post('change-favourite', [ContactController::class, 'changeFavourite'])->name('contacts.change_favourite');
    });

    //Products
    Route::group(['prefix' => 'products'], function () {
        //Category
        Route::group(['prefix' => 'categories'], function () {
            Route::get('/', [ProductCategoryController::class, 'index'])->middleware('permission:show_list_product_categories')->name('product_categories.list');
            Route::group(['middleware' => 'permission:add_product_categories'], function () {
                Route::get('add', [ProductCategoryController::class, 'getAdd'])->name('product_categories.add');
                Route::post('add', [ProductCategoryController::class, 'postAdd']);
            });
            Route::group(['middleware' => 'permission:edit_product_categories'], function () {
                Route::get('edit/{id}', [ProductCategoryController::class, 'getEdit'])->name('product_categories.edit');
                Route::put('edit/{id}', [ProductCategoryController::class, 'putEdit']);

                Route::post('change-sorting', [ProductCategoryController::class, 'changeSorting'])->name('product_categories.change_sorting');
                Route::post('change-status', [ProductCategoryController::class, 'changeStatus'])->name('product_categories.change_status');
            });
            Route::post('delete', [ProductCategoryController::class, 'delete'])->middleware('permission:delete_product_categories')->name('product_categories.delete');
        });

        //Products
        Route::group(['prefix' => 'items'], function () {
            Route::get('/', [ProductController::class, 'index'])->middleware('permission:show_list_products')->name('products.list');
            Route::get('/datatables', [ProductController::class, 'datatables'])->middleware('permission:show_list_products')->name('products.datatables');
            Route::get('/add-all-to-index', [ProductController::class, 'addAllToIndex'])->middleware('permission:show_list_products')->name('products.add_all_to_index');


            Route::group(['middleware' => 'permission:add_products'], function () {
                Route::get('add', [ProductController::class, 'getAdd'])->name('products.add');
                Route::post('add', [ProductController::class, 'postAdd']);
            });
            Route::group(['middleware' => 'permission:edit_products'], function () {
                Route::get('edit/{id}', [ProductController::class, 'getEdit'])->name('products.edit');
                Route::put('edit/{id}', [ProductController::class, 'putEdit']);

                Route::post('change-popular', [ProductController::class, 'changePopular'])->name('products.change_popular');
                Route::post('change-status', [ProductController::class, 'changeStatus'])->name('products.change_status');
                Route::post('change-sorting', [ProductController::class, 'changeSorting'])->name('products.change_sorting');
            });
            Route::post('delete', [ProductController::class, 'delete'])->middleware('permission:delete_products')->name('products.delete');
            Route::get('/clear-index', [ProductController::class, 'clearIndex'])->middleware('permission:delete_products')->name('products.clear_index');

        });


        //Scrapes
        Route::group(['prefix' => 'scrapes'], function () {
            Route::get('/', [ScrapeController::class, 'index'])->middleware('permission:show_list_scrapes')->name('scrapes.list');
            Route::get('/datatables', [ScrapeController::class, 'datatables'])->middleware('permission:show_list_scrapes')->name('scrapes.datatables');
            Route::group(['middleware' => 'permission:add_scrapes'], function () {
                Route::get('add', [ScrapeController::class, 'getAdd'])->name('scrapes.add');
                Route::post('add', [ScrapeController::class, 'postAdd']);
            });
            Route::group(['middleware' => 'permission:edit_scrapes'], function () {
                Route::get('edit/{id}', [ScrapeController::class, 'getEdit'])->name('scrapes.edit');
                Route::put('edit/{id}', [ScrapeController::class, 'putEdit']);

            });
            Route::post('delete', [ScrapeController::class, 'delete'])->middleware('permission:delete_scrapes')->name('scrapes.delete');

            Route::group(['prefix' => 'api'], function () {
                Route::post('validate-url', [ScrapeController::class, 'ApiValidateUrl']);
                Route::post('fetch-model-data', [ScrapeController::class, 'ApiFetchModelData']);
                Route::post('scrape-html', [ScrapeController::class, 'ApiScrapeHtml']);
                Route::any('get-scraped-data', [ScrapeController::class, 'ApiGetScrapedData']);
            });
        });

        //Comparisons
        Route::group(['prefix' => 'comparisons'], function () {
            Route::get('/', [ComparisonController::class, 'index'])->middleware('permission:show_list_comparisons')->name('comparisons.list');
            Route::get('/datatables', [ComparisonController::class, 'datatables'])->middleware('permission:show_list_comparisons')->name('comparisons.datatables');

            Route::group(['middleware' => 'permission:add_comparisons'], function () {
                Route::get('add', [ComparisonController::class, 'getAdd'])->name('comparisons.add');
                Route::post('add', [ComparisonController::class, 'postAdd']);
            });
            Route::group(['middleware' => 'permission:edit_comparisons'], function () {
                Route::get('edit/{id}', [ComparisonController::class, 'getEdit'])->name('comparisons.edit');
                Route::put('edit/{id}', [ComparisonController::class, 'putEdit']);

                Route::post('change-popular', [ComparisonController::class, 'changePopular'])->name('comparisons.change_popular');
                Route::post('change-status', [ComparisonController::class, 'changeStatus'])->name('comparisons.change_status');
                Route::post('change-sorting', [ComparisonController::class, 'changeSorting'])->name('comparisons.change_sorting');
            });
            Route::post('delete', [ComparisonController::class, 'delete'])->middleware('permission:delete_comparisons')->name('comparisons.delete');

            Route::group(['prefix' => 'view'], function() {
                Route::get('show/{id}', [ComparisonController::class, 'getShow'])->name('comparisons.show');
                Route::get('datatables/{id}', [ComparisonController::class, 'productDatatables'])->name('comparison_products.datatables');
                Route::post('change-relationship/{id}', [ComparisonController::class, 'productChangeRelationship'])->name('comparison_products.change_relationship');
            });
        });
    });

    //Sellers
    Route::group(['prefix' => 'sellers'], function () {
        Route::get('/', [SellerController::class, 'index'])->middleware('permission:show_list_sellers')->name('sellers.list');
        Route::get('/datatables', [SellerController::class, 'datatables'])->middleware('permission:show_list_sellers')->name('sellers.datatables');

        Route::group(['middleware' => 'permission:add_sellers'], function () {
            Route::get('add', [SellerController::class, 'getAdd'])->name('sellers.add');
            Route::post('add', [SellerController::class, 'postAdd']);
        });
        Route::group(['middleware' => 'permission:edit_sellers'], function () {
            Route::get('edit/{id}', [SellerController::class, 'getEdit'])->name('sellers.edit');
            Route::put('edit/{id}', [SellerController::class, 'putEdit']);

            Route::post('change-popular', [SellerController::class, 'changePopular'])->name('sellers.change_popular');
            Route::post('change-status', [SellerController::class, 'changeStatus'])->name('sellers.change_status');
            Route::post('change-sorting', [SellerController::class, 'changeSorting'])->name('sellers.change_sorting');
        });
        Route::post('delete', [SellerController::class, 'delete'])->middleware('permission:delete_sellers')->name('sellers.delete');
    });

    //Footer slide
    Route::group(['prefix' => 'footer-slides'], function () {
        Route::get('/', [FooterSlideController::class, 'index'])->middleware('permission:show_list_footer_slides')->name('footer_slides.list');
        Route::group(['middleware' => 'permission:add_footer_slides'], function () {
            Route::get('add', [FooterSlideController::class, 'getAdd'])->name('footer_slides.add');
            Route::post('add', [FooterSlideController::class, 'postAdd']);
        });
        Route::group(['middleware' => 'permission:edit_footer_slides'], function () {
            Route::get('edit/{id}', [FooterSlideController::class, 'getEdit'])->name('footer_slides.edit');
            Route::put('edit/{id}', [FooterSlideController::class, 'putEdit']);

            Route::post('change-sorting', [FooterSlideController::class, 'changeSorting'])->name('footer_slides.change_sorting');
            Route::post('change-status', [FooterSlideController::class, 'changeStatus'])->name('footer_slides.change_status');
        });
        Route::post('delete', [FooterSlideController::class, 'delete'])->middleware('permission:delete_footer_slides')->name('footer_slides.delete');
    });
});
