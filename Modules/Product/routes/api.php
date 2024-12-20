<?php

use Illuminate\Support\Facades\Route;
use Modules\Product\app\Http\Controllers\Admin\ProductCategoryController;
use Modules\Product\app\Http\Controllers\Admin\ProductController;
use Modules\Product\app\Http\Controllers\User\ProductController as UserProductController;

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
Route::group(['prefix' => 'product-module', 'as' => 'product.'], function () {

    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::group(['middleware' => ['auth:api-admin']], function () {
            Route::resource('products' , ProductController::class);
            Route::resource('product-categories' , ProductCategoryController::class);
        });
    });

    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        Route::resource('products' , UserProductController::class , ['only' => ['index', 'show']]);
        Route::group(['middleware' => ['auth:api']], function () {
        });

    });

});
