<?php

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
Route::group(['prefix' => 'users-module', 'as' => 'user.'], function () {

    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::post('login', [AdminController::class, 'login'])->name('admins.login');
        Route::post('register', [AdminController::class, 'register'])->name('admins.register');

        Route::group(['middleware' => ['auth:api-admin']], function () {
            Route::resource('users', AdminUserController::class)->only(['update' , 'store' , 'show' , 'index']);
            Route::resource('blocked-accounts', BlockedAccountController::class)->only(['store', 'index', 'destroy']);
        });

    });

    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        Route::post('login', [UserController::class, 'login'])->name('users.login');
        Route::post('register', [UserController::class, 'register'])->name('users.register');
        Route::post('forget-password', [UserController::class, 'forgetPassword'])->name('users.forgetPassword');
        Route::post('check-forget-password-token', [UserController::class, 'checkForgetPasswordToken'])->name('users.checkForgetPasswordToken');
        Route::put('rest-password', [UserController::class, 'resetPassword'])->name('users.resetPassword');

        Route::group(['middleware' => ['auth:api']], function () {
            Route::group(['prefix' => 'profile', 'as' => 'profiles.'], function () {
                Route::put('/', [UserProfileController::class, 'update'])->name('update');
                Route::get('/', [UserProfileController::class, 'show'])->name('show');
            });
        });
    });

});
