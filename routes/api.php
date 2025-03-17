<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\General\AuthController;
use App\Http\Controllers\General\CategoryController;
use App\Http\Controllers\General\ListController;
use App\Http\Controllers\General\UserListController;

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
    Route::get('/popular/categories', 'getPopulars');
});

Route::group([
    'prefix' => 'lists',
    'controller' => UserListController::class
], function ($router) {
    Route::get('/user/{user_id}', 'getAllForUser');
    Route::get('/show/{list_id}', 'show');
});

Route::group([
    'prefix' => 'lists',
    'controller' => ListController::class
], function ($router) {
    Route::get('/', 'getOrdinary');
    Route::get('/latests', 'getForLatest');
});
