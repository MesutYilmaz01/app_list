<?php

use App\Http\Controllers\General\ArtificialIntelligenceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\General\AuthController;
use App\Http\Controllers\General\CategoryController;
use App\Http\Controllers\General\DislikeCommentController;
use App\Http\Controllers\General\DislikeUserListController;
use App\Http\Controllers\General\FollowController;
use App\Http\Controllers\General\ListController;
use App\Http\Controllers\General\UserListController;
use App\Http\Controllers\General\LikeCommentController;
use App\Http\Controllers\General\LikeUserListController;

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

Route::group([
    'prefix' => 'likes',
], function ($router) {
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/comment/{comment_id}', [LikeCommentController::class, 'likeReverser']);
        Route::post('/user-list/{user_list_id}', [LikeUserListController::class, 'likeReverser']);
    });
});

Route::group([
    'prefix' => 'dislikes',
], function ($router) {
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/comment/{comment_id}', [DislikeCommentController::class, 'dislikeReverser']);
        Route::post('/user-list/{user_list_id}', [DislikeUserListController::class, 'dislikeReverser']);
    });
});

Route::group([
    'prefix' => 'ai',
], function ($router) {
    Route::get('/', [ArtificialIntelligenceController::class, 'communicate']);
});

Route::group([
    'prefix' => 'follow',
], function ($router) {
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/{followed_user_id}', [FollowController::class, 'followReverser']);
    });
});
