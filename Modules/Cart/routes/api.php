<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Cart\app\Http\Controllers\User\CartController;

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
Route::group(['prefix' => 'cart-module', 'as' => 'cart.'], function () {

    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    });

    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        Route::group(['middleware' => ['auth:api']], function () {
            Route::resource('/cart', CartController::class , ['only' => ['store', 'show' , 'destroy']]);
        });

    });
});
