<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\shopController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(ProductController::class)
    ->prefix('/products')
    ->name('products.')
    ->group(static function (): void {
        Route::get('', 'list')->name('list');
        Route::get('/create', 'showCreateForm')->name('create-form');
        Route::post('/create', 'create')->name('create');
        Route::prefix('/{product}')->group(static function (): void {
            Route::get('', 'view')->name('view');
            Route::get('/update', 'updateForm')->name('update-form');
            Route::post('/update', 'update')->name('update');
            Route::post('/delete', 'delete')->name('delete');
        });
    });

Route::controller(shopController::class)
    ->prefix('/shops')
    ->name('shops.')
    ->group(static function (): void {
        Route::get('', 'list')->name('list');
        Route::get('/create', 'showCreateForm')->name('create-form');
        Route::post('/create', 'create')->name('create');
        Route::prefix('/{shops}')->group(static function (): void {
            Route::get('', 'view')->name('view');
            Route::get('/update', 'updateForm')->name('update-form');
            Route::post('/update', 'update')->name('update');
            Route::post('/delete', 'delete')->name('delete');
        });
    });
