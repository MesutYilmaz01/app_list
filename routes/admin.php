
<?php

use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'categories',
    'controller' => CategoryController::class
], function ($router) {
    Route::get('/', 'getAll');
    Route::get('/{category_id}', 'show');
    Route::get('/popular/categories', 'getPopulars');
    Route::middleware('auth:sanctum', 'is_admin')->group(function () {
        Route::post('/', 'create');
        Route::put('/{category_id}', 'update');
        Route::delete('/{category_id}', 'delete');
    });
});