<?php

use App\Http\Controllers\Owner\CompleteProfileController;
use App\Http\Controllers\Owner\DashboardController;
use App\Http\Controllers\Owner\Products\ProductBrandController;
use App\Http\Controllers\Owner\Products\ProductsCategoryController;
use App\Http\Controllers\Owner\Products\ProductsController;
use App\Http\Controllers\Owner\Sales\POSController;
use App\Http\Controllers\Owner\Settings\StoreController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'owner', 'as' => 'owner.', 'middleware' => ['auth', 'role:owner']], function () {

    // Complete Profile
    Route::group(['prefix' => 'complete-profile', 'as' => 'complete-profile.'], function () {
        Route::get('', [CompleteProfileController::class, 'index'])->name('index');
        Route::put('{id}', [CompleteProfileController::class, 'update'])->name('update');
        Route::post('get-regencies', [CompleteProfileController::class, 'getRegencies'])->name('getRegencies');
        Route::post('get-district', [CompleteProfileController::class, 'getDistrict'])->name('getDistrict');
        Route::post('get-village', [CompleteProfileController::class, 'getVillage'])->name('getVillage');
    });

    Route::group(['middleware' => ['hasStore']], function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('{id}', [DashboardController::class, 'setSession'])->name('setSession');
        Route::get('', [DashboardController::class, 'deleteSession'])->name('deleteSession');

        Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
            Route::group(['middleware' => ['alreadySelectShop']], function () {
                // untuk products
                Route::get('list', [ProductsController::class, 'index'])->name('index');
                Route::get('create', [ProductsController::class, 'create'])->name('add');
                Route::post('', [ProductsController::class, 'store'])->name('store');
                Route::get('{id}/edit', [ProductsController::class, 'edit'])->name('edit');
                Route::put('{id}', [ProductsController::class, 'update'])->name('update');
                Route::delete('{id}', [ProductsController::class, 'destroy'])->name('delete');
            });

            Route::group(['prefix' => 'category', 'as' => 'category.'], function () {
                Route::get('', [ProductsCategoryController::class, 'index'])->name('index');
                Route::get('add', [ProductsCategoryController::class, 'create'])->name('add');
                Route::post('', [ProductsCategoryController::class, 'store'])->name('store');
                Route::get('{id}/edit', [ProductsCategoryController::class, 'edit'])->name('edit');
                Route::put('{id}', [ProductsCategoryController::class, 'update'])->name('update');
                Route::get('{id}', [ProductsCategoryController::class, 'destroy'])->name('delete');
            });
            Route::group(['prefix' => 'brand', 'as' => 'brand.'], function () {
                Route::get('', [ProductBrandController::class, 'index'])->name('index');
                Route::get('add', [ProductBrandController::class, 'create'])->name('add');
                Route::post('', [ProductBrandController::class, 'store'])->name('store');
                Route::get('{id}/edit', [ProductBrandController::class, 'edit'])->name('edit');
                Route::put('{id}', [ProductBrandController::class, 'update'])->name('update');
                Route::get('{id}', [ProductBrandController::class, 'destroy'])->name('delete');
            });
        });

        Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
            Route::group(['prefix' => 'store', 'as' => 'store.'], function () {
                Route::get('', [StoreController::class, 'index'])->name('index');
                Route::get('add', [StoreController::class, 'create'])->name('add');
                Route::post('', [StoreController::class, 'store'])->name('store');
                Route::get('{id}/edit', [StoreController::class, 'edit'])->name('edit');
                Route::put('{id}', [StoreController::class, 'update'])->name('update');
                Route::get('{id}', [StoreController::class, 'destroy'])->name('delete');
            });
        });

        Route::group(['prefix' => 'sales', 'as' => 'sales.', 'middleware' => ['alreadySelectShop']], function () {
            Route::group(['prefix' => 'pos', 'as' => 'pos.'], function () {
                Route::get('', [POSController::class, 'index'])->name('index');
                Route::post('', [POSController::class, 'store'])->name('store');
            });
        });
    });
});
