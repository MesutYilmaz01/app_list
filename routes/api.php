<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\UserListController;
use App\Http\Controllers\UserListsItemController;

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
    Route::get('/', 'getAll');
    Route::get('/{category_id}', 'show');
    Route::middleware('auth:sanctum', 'is_admin')->group(function () {
        Route::post('/', 'create');
        Route::put('/{category_id}', 'update');
        Route::delete('/{category_id}', 'delete');
    });
});

Route::group([
    'prefix' => 'lists',
    'controller' => UserListController::class
], function ($router) {
    Route::get('/user/{user_id}', 'getAllForUser');
    Route::get('/show/{list_id}', 'show');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', 'create');
        Route::put('/{list_id}', 'update');
        Route::delete('/{list_id}', 'delete');
    });
});

Route::group([
    'prefix' => 'lists',
    'controller' => ListController::class
], function ($router) {
    Route::get('/', 'get');
});

Route::group([
    'prefix' => 'list-items',
    'controller' => UserListsItemController::class
], function ($router) {
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', 'create');
        Route::put('/{list_item_id}', 'update');
        Route::delete('/{list_item_id}', 'delete');
    });
});
