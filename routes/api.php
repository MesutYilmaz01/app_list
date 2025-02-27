<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserListController;

Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
    });
});

Route::group([
    'prefix' => 'categories',
    'controller' => CategoryController::class
], function ($router) {
    Route::get('/','getAll');
    Route::get('/{id}', 'show');
    Route::middleware('auth:sanctum', 'is_admin')->group(function () {
        Route::post('/', 'create');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'delete');
    });
});

Route::group([
    'prefix' => 'lists',
    'controller' => UserListController::class
], function ($router) {
    Route::get('/{user_id}','getAllForUser');
    Route::get('/show/{list_id}', 'get');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', 'create');
        //Route::put('/{id}', 'update');
        //Route::delete('/{id}', 'delete');
    });
});
