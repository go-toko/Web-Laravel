<?php

use App\Http\Controllers\Owner\CompleteProfileController;
use App\Http\Controllers\Owner\DashboardController;
use App\Http\Controllers\Owner\Expenses\ExpensesCategoryController;
use App\Http\Controllers\Owner\Expenses\ExpensesController;
use App\Http\Controllers\Owner\Expenses\ExpensesStatisticController;
use App\Http\Controllers\Owner\People\CashierController;
use App\Http\Controllers\Owner\People\SupplierController;
use App\Http\Controllers\Owner\Products\ProductBrandController;
use App\Http\Controllers\Owner\Products\ProductsCategoryController;
use App\Http\Controllers\Owner\Products\ProductsController;
use App\Http\Controllers\Owner\Products\RestockController;
use App\Http\Controllers\Owner\Sales\POSController;
use App\Http\Controllers\Owner\Sales\SalesController;
use App\Http\Controllers\Owner\Sales\SalesProfitController;
use App\Http\Controllers\Owner\Sales\SalesStatisticController;
use App\Http\Controllers\Owner\Settings\CashFlowController;
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
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/{id}', [DashboardController::class, 'setSession'])->name('setSession');
        Route::get('/', [DashboardController::class, 'deleteSession'])->name('deleteSession');
        Route::post('/get-expense', [DashboardController::class, 'getExpenses'])->name('getExpenses');
        Route::post('/get-sale', [DashboardController::class, 'getSales'])->name('getSales');

        Route::group(['prefix' => 'produk', 'as' => 'produk.'], function () {
            Route::group(['middleware' => ['alreadySelectShop'], 'prefix' => 'daftar-produk', 'as' => 'daftar-produk.'], function () {
                // untuk products
                Route::get('/', [ProductsController::class, 'index'])->name('index');
                Route::get('/create', [ProductsController::class, 'create'])->name('add');
                Route::post('/', [ProductsController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [ProductsController::class, 'edit'])->name('edit');
                Route::put('/updateDiskon/{id}', [ProductsController::class, 'updateDiskon'])->name('updateDiskon');
                Route::put('/restore/{id}', [ProductsController::class, 'restore'])->name('restore');
                Route::put('/{id}', [ProductsController::class, 'update'])->name('update');
                Route::delete('/{id}', [ProductsController::class, 'destroy'])->name('delete');
                Route::post('/checkSKU', [ProductsController::class, 'checkSKU'])->name('checkSKU');
                Route::get('/reportPdf', [ProductsController::class, 'reportPdf'])->name('reportPdf');
                Route::get('/reportExcel', [ProductsController::class, 'reportExcel'])->name('reportExcel');
                Route::get('/produk-database', [ProductsController::class, 'getProductsFromProductsDatabase'])->name('getProductsDatabase');
                Route::get('/one-produk-database', [ProductsController::class, 'getOneProductsFromProductsDatabase'])->name('getOneProductsDatabase');
                Route::get('/getData/{id}', [ProductsController::class, 'getData'])->name('getData');
            });

            Route::group(['middleware' => ['alreadySelectShop'], 'prefix' => 'restock', 'as' => 'restock.'], function () {
                Route::get('/', [RestockController::class, 'index'])->name('index');
                Route::get('/add', [RestockController::class, 'create'])->name('add');
                Route::get('/{id}', [RestockController::class, 'show'])->name('detail');
                Route::post('/', [RestockController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [RestockController::class, 'edit'])->name('edit');
                Route::put('/validasi/{id}', [RestockController::class, 'validasiData'])->name('validasiData');
                Route::put('/tambahkan-stok/{id}', [RestockController::class, 'tambahkanStok'])->name('tambahkanStok');
                Route::put('/batalkan/{id}', [RestockController::class, 'batalkan'])->name('batalkan');
                Route::put('/{id}', [RestockController::class, 'update'])->name('update');
                Route::delete('/{id}', [RestockController::class, 'destroy'])->name('delete');
            });

            Route::group(['prefix' => 'kategori', 'as' => 'kategori.'], function () {
                Route::get('/', [ProductsCategoryController::class, 'index'])->name('index');
                Route::get('/add', [ProductsCategoryController::class, 'create'])->name('add');
                Route::post('/', [ProductsCategoryController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [ProductsCategoryController::class, 'edit'])->name('edit');
                Route::put('/restore/{id}', [ProductsCategoryController::class, 'restore'])->name('restore');
                Route::put('/{id}', [ProductsCategoryController::class, 'update'])->name('update');
                Route::delete('/nonaktif/{id}', [ProductsCategoryController::class, 'nonaktif'])->name('nonaktif');
                Route::delete('/{id}', [ProductsCategoryController::class, 'destroy'])->name('destroy');
                Route::get('/reportPdf', [ProductsCategoryController::class, 'reportPdf'])->name('reportPdf');
                Route::get('/reportExcel', [ProductsCategoryController::class, 'reportExcel'])->name('reportExcel');
            });
            Route::group(['prefix' => 'merek', 'as' => 'merek.'], function () {
                Route::get('/', [ProductBrandController::class, 'index'])->name('index');
                Route::get('/add', [ProductBrandController::class, 'create'])->name('add');
                Route::post('/', [ProductBrandController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [ProductBrandController::class, 'edit'])->name('edit');
                Route::put('/restore/{id}', [ProductBrandController::class, 'restore'])->name('restore');
                Route::put('/{id}', [ProductBrandController::class, 'update'])->name('update');
                Route::delete('/nonaktif/{id}', [ProductBrandController::class, 'nonaktif'])->name('nonaktif');
                Route::delete('/{id}', [ProductBrandController::class, 'destroy'])->name('destroy');
                Route::get('/reportPdf', [ProductBrandController::class, 'reportPdf'])->name('reportPdf');
                Route::get('/reportExcel', [ProductBrandController::class, 'reportExcel'])->name('reportExcel');
            });
        });

        Route::group(['prefix' => 'pengeluaran', 'as' => 'pengeluaran.'], function () {
            Route::group(['middleware' => ['alreadySelectShop'], 'prefix' => 'pengeluaran', 'as' => 'pengeluaran.'], function () {
                Route::get('/', [ExpensesController::class, 'index'])->name('index');
                Route::get('/add', [ExpensesController::class, 'create'])->name('add');
                Route::post('/', [ExpensesController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [ExpensesController::class, 'edit'])->name('edit');
                Route::get('/{id}/show', [ExpensesController::class, 'show'])->name('detail');
                Route::put('/{id}', [ExpensesController::class, 'update'])->name('update');
                Route::delete('/{id}', [ExpensesController::class, 'destroy'])->name('delete');
                Route::get('/report-pdf', [ExpensesController::class, 'reportPdf'])->name('reportPdf');
                Route::get('/report-excel', [ExpensesController::class, 'reportExcel'])->name('reportExcel');
                Route::patch('/{id}', [ExpensesController::class, 'updateStatus'])->name('updateStatus');
            });
            Route::group(['prefix' => 'kategori', 'as' => 'kategori.'], function () {
                Route::get('/', [ExpensesCategoryController::class, 'index'])->name('index');
                Route::get('/add', [ExpensesCategoryController::class, 'create'])->name('add');
                Route::post('/', [ExpensesCategoryController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [ExpensesCategoryController::class, 'edit'])->name('edit');
                Route::put('/restore/{id}', [ExpensesCategoryController::class, 'restore'])->name('restore');
                Route::put('/{id}', [ExpensesCategoryController::class, 'update'])->name('update');
                Route::delete('/nonaktif/{id}', [ExpensesCategoryController::class, 'nonaktif'])->name('nonaktif');
                Route::delete('/{id}', [ExpensesCategoryController::class, 'destroy'])->name('destroy');
            });
            Route::group(['prefix' => 'statistik', 'as' => 'statistik.'], function () {
                Route::get('/', [ExpensesStatisticController::class, 'index'])->name('index');
                Route::post('/pengeluaran', [ExpensesStatisticController::class, 'getExpenses'])->name('pengeluaran');
                Route::post('/kategori', [ExpensesStatisticController::class, 'getCategoryExpense'])->name('kategori');
            });
        });

        Route::group(['prefix' => 'penjualan', 'as' => 'penjualan.'], function () {
            Route::group(['middleware' => ['alreadySelectShop'], 'prefix' => 'penjualan', 'as' => 'penjualan.'], function () {
                Route::get('/', [SalesController::class, 'index'])->name('index');
                Route::get('/report-pdf', [SalesController::class, 'reportPdf'])->name('reportPdf');
                Route::get('/report-excel', [SalesController::class, 'reportExcel'])->name('reportExcel');
                Route::get('/{id}', [SalesController::class, 'show'])->name('detail');
            });
            Route::group(['prefix' => 'statistik-penjualan', 'as' => 'statistik-penjualan.'], function () {
                Route::get('/', [SalesStatisticController::class, 'index'])->name('index');
                Route::post('/penjualan', [SalesStatisticController::class, 'getSales'])->name('penjualan');
            });

            Route::group(['prefix' => 'laba-penjualan', 'as' => 'laba-penjualan.'], function () {
                Route::get('/', [SalesProfitController::class, 'index'])->name('index');
                Route::post('/laba', [SalesProfitController::class, 'getProfit'])->name('laba');
            });
        });

        Route::group(['prefix' => 'orang', 'as' => 'orang.'], function () {
            Route::group(['prefix' => 'kasir', 'as' => 'kasir.'], function () {
                Route::get('/', [CashierController::class, 'index'])->name('index');
                Route::get('/add', [CashierController::class, 'create'])->name('add');
                Route::post('/', [CashierController::class, 'store'])->name('store');
                Route::put('', [CashierController::class, 'updateOrDeleteAkses'])->name('updateOrDeleteAkses');
                Route::get('/{email}', [CashierController::class, 'cashierByEmail'])->name('getCashierByEmail');
            });

            Route::group(['prefix' => 'pemasok', 'as' => 'pemasok.'], function () {
                Route::get('/', [SupplierController::class, 'index'])->name('index');
                Route::get('/add', [SupplierController::class, 'create'])->name('add');
                Route::post('/', [SupplierController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [SupplierController::class, 'edit'])->name('edit');
                Route::put('/{id}', [SupplierController::class, 'update'])->name('update');
                Route::get('/report-pdf', [SupplierController::class, 'reportPdf'])->name('reportPdf');
                Route::get('/report-excel', [SupplierController::class, 'reportExcel'])->name('reportExcel');
                Route::get('/{id}', [SupplierController::class, 'show'])->name('show');
            });
        });

        Route::group(['prefix' => 'pengaturan', 'as' => 'pengaturan.'], function () {
            Route::group(['prefix' => 'daftar-toko', 'as' => 'daftar-toko.'], function () {
                Route::get('/', [StoreController::class, 'index'])->name('index');
                Route::get('/add', [StoreController::class, 'create'])->name('add');
                Route::post('/', [StoreController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [StoreController::class, 'edit'])->name('edit');
                Route::put('/restore/{id}', [StoreController::class, 'restore'])->name('restore');
                Route::put('/{id}', [StoreController::class, 'update'])->name('update');
                Route::delete('/{id}', [StoreController::class, 'destroy'])->name('delete');
            });

            Route::group(['prefix' => 'arus-kas', 'as' => 'arus-kas.'], function () {
                Route::get('/', [CashFlowController::class, 'index'])->name('index');
                Route::post('/cash-flow', [CashFlowController::class, 'getCashFlow'])->name('getData');
            });
        });

        Route::group(['prefix' => 'sales', 'as' => 'sales.', 'middleware' => ['alreadySelectShop']], function () {
            Route::group(['prefix' => 'pos', 'as' => 'pos.'], function () {
                Route::get('/', [POSController::class, 'index'])->name('index');
                Route::post('/', [POSController::class, 'store'])->name('store');
            });
        });
    });
});
