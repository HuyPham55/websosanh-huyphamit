<?php

use App\Http\Controllers\Frontend\Auth\Api\LoginController;
use App\Http\Controllers\Frontend\Auth\Api\RegisterController;
use App\Http\Controllers\Frontend\ComparisonController;
use App\Http\Controllers\Frontend\NewsController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return auth()->guard('member')->user();
});

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::post('/member/logout', [LoginController::class, 'logout']);
});


Route::post('/member/login', [LoginController::class, 'login']);
Route::post('/member/register', [RegisterController::class, 'register']);

Route::post('/fetch-layout-data', [HomeController::class, "fetchLayoutData"]);
Route::post('/fetch-home-page', [HomeController::class, "fetchHomePage"]);

Route::post('/fetch-product-category', [ProductController::class, 'fetchCategoryData']);
Route::post('/filter-product', [ProductController::class, 'filterProduct']);
Route::post('/get-product-url', [ProductController::class, 'getProductUrl']);
Route::post('/search-by-keyword', [ProductController::class, 'searchByKeyword']);
Route::post('/fetch-comparison-data', [ComparisonController::class, 'fetchComparisonData']);
Route::post('/get-comparison-sellers', [ComparisonController::class, 'getComparisonSellers']);
Route::post('/fetch-aside-news', [NewsController::class, 'fetchAsideNews']);
Route::post('/fetch-news-detail', [NewsController::class, 'fetchModelData']);

Route::get('/search', [SearchController::class, 'search']);

