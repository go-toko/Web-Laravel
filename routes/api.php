<?php

use App\Http\Controllers\Payment\PaydisiniController;
use App\Http\Controllers\Superadmin\Payment\PaymentManagementController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('payment', [PaymentManagementController::class, 'list']);
Route::post('payment/paydisini/callback', [PaydisiniController::class, 'callback']);
Route::post('payment/paydisini/{nama}', [PaydisiniController::class, 'create']);