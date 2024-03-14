<?php

use App\Http\Controllers\Cashier\DashboardController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'cashier', 'as'=>'cashier.', 'middleware' => ['auth', 'role:cashier']], function(){
    Route::get('dashboard', [DashboardController::class,'index'])->name('dashboard');
});