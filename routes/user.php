
<?php

use App\Http\Controllers\User\CommentController;
use App\Http\Controllers\User\UserAuthorityController;
use App\Http\Controllers\User\UserListController;
use App\Http\Controllers\User\UserListsItemController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum', 'is_admin'])->group(function () {
    Route::group([
        'prefix' => 'lists',
        'controller' => UserListController::class
    ], function ($router) {
        Route::get('/user/{user_id}', 'getAllForUser');
        Route::get('/show/{list_id}', 'show');
        Route::post('/', 'create');
        Route::put('/{list_id}', 'update');
        Route::delete('/{list_id}', 'delete');
    });

    Route::group([
        'prefix' => 'list-items',
        'controller' => UserListsItemController::class
    ], function ($router) {
        Route::get('/show/{list_item_id}', 'show');
        Route::post('/', 'create');
        Route::put('/{list_item_id}', 'update');
        Route::delete('/{list_item_id}', 'delete');
    });

    Route::group([
        'prefix' => 'comments',
        'controller' => CommentController::class
    ], function ($router) {
        Route::get('/show/{comment_id}', 'show');
        Route::post('/', 'create');
        Route::put('/{comment_id}', 'update');
        Route::delete('/{comment_id}', 'delete');
    });

    Route::group([
        'prefix' => 'user-authorities',
        'controller' => UserAuthorityController::class
    ], function ($router) {
        Route::get('/user-list/{user_list_id}', 'getAllForUserList');
        Route::get('/{user_authority_id}', 'show');
        Route::post('/', 'create');
        Route::put('/{user_authority_id}', 'update');
        Route::delete('/{user_authority_id}', 'delete');
    });
});
