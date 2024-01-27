<?php

use Illuminate\Support\Facades\Route;
use Modules\Shop\app\Http\Controllers\Admin\ProductController;
use Modules\User\app\Http\Controllers\Admin\AdminController;
use Modules\User\app\Http\Controllers\Admin\BlockedAccountController;
use Modules\User\app\Http\Controllers\Admin\UserController as AdminUserController;
use Modules\User\app\Http\Controllers\User\UserController;
use Modules\User\app\Http\Controllers\User\UserProfileController;

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
Route::group(['prefix' => 'shop-module', 'as' => 'shop.'], function () {

    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::group(['middleware' => ['auth:api-admin']], function () {
            Route::resource('products' , ProductController::class);
        });
    });

    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {

        Route::group(['middleware' => ['auth:api']], function () {
        });

    });

});
