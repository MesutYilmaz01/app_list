
<?php

use App\Http\Controllers\User\CommentController;
use App\Http\Controllers\User\UserListController;
use App\Http\Controllers\User\UserListsItemController;
use Illuminate\Support\Facades\Route;

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
    'prefix' => 'list-items',
    'controller' => UserListsItemController::class
], function ($router) {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/show/{list_item_id}', 'show');
        Route::post('/', 'create');
        Route::put('/{list_item_id}', 'update');
        Route::delete('/{list_item_id}', 'delete');
    });
});

Route::group([
    'prefix' => 'comments',
    'controller' => CommentController::class
], function ($router) {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/show/{comment_id}', 'show');
        Route::post('/', 'create');
        Route::put('/{comment_id}', 'update');
        Route::delete('/{comment_id}', 'delete');
    });
});