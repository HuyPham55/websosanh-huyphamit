<?php

use App\Http\Controllers\Frontend\Auth\Api\LoginController;
use App\Http\Controllers\Frontend\Auth\Api\RegisterController;
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


