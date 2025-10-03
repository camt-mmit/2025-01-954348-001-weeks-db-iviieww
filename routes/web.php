<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\shopController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'cache.headers:no_store;no_cache;must_revalidate;max_age=0',
])->group(function () {

    Route::get('/', function () {
        return view('welcome');
    });

    Route::controller(LoginController::class)
        ->prefix('auth')
        ->group(static function (): void {
            Route::get('/login', 'showForm')->name('login');
            Route::post('/login', 'authenticate')->name('authenticate');
            Route::post('/logout', 'logout')->name('logout');
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
                Route::prefix('/shops')->group(static function (): void {
                    Route::get('', 'viewShops',)->name('view-shops');
                    Route::get('/add', 'showAddShopsForm')->name('add-shops-form');
                    Route::post('/add', 'addShop')->name('add-shop');
                    Route::post('/remove', 'removeShop')->name('remove-shop');
                });
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
                Route::prefix('/shops')->group(static function (): Void {
                    Route::get('/', 'viewProducts',)->name('view-products');
                    Route::get('/add', 'showAddProductsForm')->name('add-products-form');
                    Route::post('/add', 'addProduct')->name('add-products');
                    Route::post('/remove', 'removeProduct')->name('remove-product');
                });
            });
        });

    Route::controller(CategoryController::class)
        ->prefix('/categories')
        ->name('categories.')
        ->group(static function (): void {
            Route::get('', 'list')->name('list');
            Route::get('/create', 'showCreateForm')->name('create-form');
            Route::post('/create', 'create')->name('create');
            Route::prefix('/{catCode}')->group(static function (): void {
                Route::get('', 'view')->name('view');
                Route::get('/update', 'updateForm')->name('update-form');
                Route::post('/update', 'update')->name('update');
                Route::post('/delete', 'delete')->name('delete');
                Route::prefix('/categories')->group(static function (): Void {
                    Route::get('/', 'viewProducts')->name('view-products');
                    Route::get('/add', 'showAddProductsForm')->name('add-products-form');
                    Route::post('/add', 'addProduct')->name('add-products');
                });
            });
        });

    Route::controller(UserController::class)
        ->prefix('/users')
        ->name('users.')
        ->group(static function (): void{
            Route::get('','list')->name('list');
            Route::get('/create','showCreateForm')->name('create-form');
            Route::post('/create','create')->name('create');
            Route::get('/selves-view','selvesView')->name('selves-view');
            Route::prefix('/{userCode}')->group(static function (): void{
                Route::get('/view','view')->name('view');
                Route::get('/update-form','updateForm')->name('update-form');
                Route::post('/update','update')->name('update');
            });
        });
});
