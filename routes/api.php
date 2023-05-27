<?php

use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\User\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::group(['middleware' => ['api', 'checkPassword', 'changeLang'], 'namespace' => 'Api'], function () {
    Route::post('/get-main-categories', [CategoriesController::class, 'index']);
    Route::post('/get-category-byId', [CategoriesController::class, 'getCategoryById']);
    Route::post('change-category-status', [CategoriesController::class, 'changeStatus']);
    Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth.guard:admin-api']);
        //invalidate the token  security side

        //broken access controller user enumeration
    });
    Route::group((['prefix' => 'user', 'namespace' => 'User']), function () {
        Route::post('login', [UserController::class, 'login']);
        Route::post('register', [UserController::class, 'register']);
    });
    Route::group((['prefix' => 'user', 'middleware' => 'auth.guard:user-api']), function () {
        Route::post('profile', function () {
            return Auth::user();
        });
    });
});
Route::group(['middleware' => ['api', 'checkPassword', 'changeLang', 'checkAdminToken:admin-api'], 'namespace' => 'Api'], function () {
    Route::get('offers', [AuthController::class, 'index']);
});
