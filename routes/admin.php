
<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ListController;
use App\Http\Controllers\Admin\UserListController;
use App\Http\Controllers\Admin\UserListsItemController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'is_admin'])->group(function () {
    Route::group([
        'prefix' => 'categories',
        'controller' => CategoryController::class
    ], function ($router) {
        Route::get('/', 'getAll');
        Route::get('/{category_id}', 'show');
        Route::get('/popular/categories', 'getPopulars');
        Route::post('/', 'create');
        Route::put('/{category_id}', 'update');
        Route::delete('/{category_id}', 'delete');
    });
    
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
        Route::post('/', 'create');
        Route::put('/{list_item_id}', 'update');
        Route::delete('/{list_item_id}', 'delete');
    });
    
    Route::group([
        'prefix' => 'lists',
        'controller' => ListController::class
    ], function ($router) {
        Route::get('/', 'getOrdinary');
        Route::get('/latests', 'getForLatest');
    });
});