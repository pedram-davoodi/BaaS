<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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
Route::group(['prefix' => 'users-module'] , function (){

    Route::group(['prefix' => 'admin'] , function (){
        Route::post('login', [AdminController::class , 'login']);
        Route::post('register', [AdminController::class , 'register']);

        Route::group(['middleware' => ['auth:api-admin']] , function (){
            Route::resource('users' , AdminUserController::class);
            Route::resource('blocked-accounts', BlockedAccountController::class)->only(['store' , 'index' , 'destroy']);
        });

    });

    Route::group(['prefix' => 'user'] , function (){
        Route::post('login', [UserController::class , 'login']);
        Route::post('register', [UserController::class , 'register']);
        Route::post('forget-password', [UserController::class , 'forgetPassword']);
        Route::post('check-forget-password-token', [UserController::class , 'checkForgetPasswordToken']);
        Route::put('rest-password', [UserController::class , 'resetPassword']);

        Route::group(['middleware' => ['auth:api']] , function (){
            Route::group(['prefix' => 'profile'] , function (){
                Route::put('/' , [UserProfileController::class , 'update']);
                Route::get('/' , [UserProfileController::class , 'show']);
            });

        });
    });

});
