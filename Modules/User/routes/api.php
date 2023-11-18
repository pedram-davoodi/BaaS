<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\User\app\Http\Controllers\Admin\AdminController;
use Modules\User\app\Http\Controllers\Admin\UserController as AdminUserController;
use Modules\User\app\Http\Controllers\User\UserController;

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
Route::group(['prefix' => 'users-module'] , function (){

    Route::group(['prefix' => 'admin'] , function (){
        Route::resource('user' , AdminUserController::class);
    });

    Route::group(['prefix' => 'user'] , function (){
        Route::post('login', [UserController::class , 'login']);
        Route::post('register', [UserController::class , 'register']);
    });


    Route::group(['prefix' => 'admin'] , function (){
        Route::post('login', [AdminController::class , 'login']);
        Route::post('register', [AdminController::class , 'register']);
    });

});
