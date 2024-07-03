<?php

use App\Http\Controllers\Subscription\MenuSubscriptionController;
use App\Http\Controllers\Superadmin\DashboardController;
use App\Http\Controllers\Superadmin\People\ShopManagementController;
use App\Http\Controllers\Superadmin\People\UserManagementController;
use App\Http\Controllers\Superadmin\Settings\MenuController;
use App\Http\Controllers\Superadmin\Settings\SubmenuController;
use App\Http\Controllers\Superadmin\Subscription\SubscriptionManagementController;
use App\Http\Controllers\Superadmin\Subscription\SubscriptionOrderController;
use App\Http\Controllers\Superadmin\Payment\PaymentManagementController;
use App\Http\Controllers\Superadmin\Payment\PaymentTransactionController;
use App\Http\Controllers\Superadmin\Payment\PaymentWithdrawalController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'superadmin', 'as' => 'superadmin.', 'middleware' => ['auth', 'role:superadmin']], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('getUserCount', [DashboardController::class, 'getUserCount'])->name('getUserCount');
    Route::get('getUserOnlineUserCount', [DashboardController::class, 'getUserOnlineCount'])->name('getUserOnlineCount');
    Route::get('getSubscriber', [DashboardController::class, 'getSubscriberCount'])->name('getSubscriberCount');
    Route::get('getSubscriberChart', [DashboardController::class, 'getSubscriberChart'])->name('getSubscriberChart');
    Route::get('getShopsCount', [DashboardController::class, 'getShopsCount'])->name('getShopsCount');

    //settings URL's Group
    Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {

        //menu URL's Group
        Route::group(['prefix' => 'menu-management', 'as' => 'menu.'], function () {
            Route::get('', [MenuController::class, 'index'])->name('index');
            Route::post('store', [MenuController::class, 'store'])->name('store');
            Route::post('{id}/update', [MenuController::class, 'update'])->name('update');
            Route::post('destroy/{id}', [MenuController::class, 'destroy'])->name('destroy');
            Route::get('report-pdf', [MenuController::class, 'reportPdf'])->name('report-pdf');
            Route::post('update-order', [MenuController::class, 'updateOrder'])->name('updateOrder');

            //submenu URL's Group
            Route::group(['prefix' => 'submenu', 'as' => 'submenu.'], function () {
                Route::post('store', [SubmenuController::class, 'store'])->name('store');
                Route::post('{id}/update', [SubmenuController::class, 'update'])->name('update');
                Route::post('destroy/{id}', [SubmenuController::class, 'destroy'])->name('destroy');
            });
        });
    });

    //people URL's Group
    Route::group(['prefix' => 'people', 'as' => 'people.'], function () {

        //user management URL's Group
        Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
            Route::get('', [UserManagementController::class, 'index'])->name('index');
            Route::post('getData', [UserManagementController::class, 'getData'])->name('getData');
            Route::get('report-pdf', [UserManagementController::class, 'reportPdf'])->name('report-pdf');
            Route::get('report-excel', [UserManagementController::class, 'reportExcel'])->name('report-excel');
            Route::get('show/{id}', [UserManagementController::class, 'show'])->name('show');
            Route::get('report-detail-pdf/{id}', [UserManagementController::class, 'reportDetailPdf'])->name('report-detail-pdf');
            Route::get('report-detail-excel/{id}', [UserManagementController::class, 'reportDetailExcel'])->name('report-detail-excel');
            Route::post('{id}/update', [UserManagementController::class, 'update'])->name('update');
        });

        Route::group(['prefix' => 'shop', 'as' => 'shop.'], function () {
            Route::get('', [ShopManagementController::class, 'index'])->name('index');
            Route::get('report-pdf', [ShopManagementController::class, 'reportPdf'])->name('report-pdf');
            Route::get('report-excel', [ShopManagementController::class, 'reportExcel'])->name('report-excel');
            Route::get('show/{id}', [ShopManagementController::class, 'show'])->name('show');
            Route::get('report-detail-pdf/{id}', [ShopManagementController::class, 'reportDetailPdf'])->name('report-detail-pdf');
            Route::get('report-detail-excel/{id}', [ShopManagementController::class, 'reportDetailExcel'])->name('report-detail-excel');
            Route::post('{id}/update', [ShopManagementController::class, 'update'])->name('update');
        });

    });
    
    //subscription URL's Group
    Route::group(['prefix' => 'subscription', 'as' => 'subscription.'], function () {

        //subscription menu URL's Group
        Route::group(['prefix' => 'menu-management', 'as' => 'menu.'], function () {
            Route::get('', [MenuSubscriptionController::class, 'index'])->name('index');
            Route::post('store', [MenuSubscriptionController::class, 'store'])->name('store');
            Route::post('{id}/update', [MenuSubscriptionController::class, 'update'])->name('update');
            Route::post('destroy/{id}', [MenuSubscriptionController::class, 'destroy'])->name('destroy');
        });

        Route::group(['prefix' => 'subscription-management', 'as' => 'management.'], function () {
            Route::get('', [SubscriptionManagementController::class, 'index'])->name('index');
            Route::post('store', [SubscriptionManagementController::class, 'store'])->name('store');
            Route::post('{id}/update', [SubscriptionManagementController::class, 'update'])->name('update');
            Route::post('destroy/{id}', [SubscriptionManagementController::class, 'destroy'])->name('destroy');
            Route::get('report-pdf', [SubscriptionManagementController::class, 'reportPdf'])->name('report-pdf');
            Route::get('report-excel', [SubscriptionManagementController::class, 'reportExcel'])->name('report-excel');
        });

        Route::group(['prefix' => 'subscription-order', 'as' => 'subscription-order.'], function(){
            Route::get('', [SubscriptionOrderController::class, 'index'])->name('index');
            Route::get('report-pdf', [SubscriptionOrderController::class, 'reportPdf'])->name('report-pdf');
            Route::get('report-excel', [SubscriptionOrderController::class, 'reportExcel'])->name('report-excel');
        });
    });


     // Payment URL's Group
     Route::group(['prefix' => 'payment', 'as' => 'payment.'], function () {
        // Payment Management URL's Group
        Route::get('management', [PaymentManagementController::class, 'index'])->name('management');
        Route::get('edit/{id}/{status}', [PaymentManagementController::class, 'edit'])->name('edit');

        // Payment Transaction URL's Group
        Route::get('shops', [PaymentTransactionController::class, 'index'])->name('shop');
        Route::get('shop/{id}', [PaymentTransactionController::class, 'detail'])->name('shop.show');

        // Payment Withdrawal URL's Group
        Route::get('withdrawal', [PaymentWithdrawalController::class, 'index'])->name('withdrawal');
        Route::get('withdrawal/{id}/{status}', [PaymentWithdrawalController::class, 'edit'])->name('withdrawal.edit');
    });
});
