<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\General\MyProfileController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [LoginController::class, 'index'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.post');
Route::get('/register', [RegisterController::class, 'index'])->middleware('guest')->name('register');
Route::post('/register', [RegisterController::class, 'register'])->middleware('guest')->name('register.post');
Route::get('/login/google', [LoginController::class, 'redirectGoogle'])->middleware('guest')->name('login.google');
Route::get('/login/google/callback', [LoginController::class, 'handleGoogleCallback'])->name('login.google.callback');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/privacy-policy', function () {
    return view('page.guest.privacy-policy');
})->name('policy');

Route::group(['prefix' => 'my-profile', 'as' => 'my-profile.', 'middleware' => ['auth']], function () {
    Route::get('', [MyProfileController::class, 'index'])->name('index');
    Route::post('{id}/update', [MyProfileController::class, 'update'])->name('update');
});

Route::get('subscription', [SubscriptionController::class, 'index'])->name('subscription');
Route::post('subscription/add', [SubscriptionController::class, 'add'])->name('subscription.add');
Route::post('subscription/payment', [SubscriptionController::class, 'processPayment'])->name('subscription.payment');

// Route for other role
require __DIR__ . '/superadmin.php';
require __DIR__ . '/owner.php';
require __DIR__ . '/cashier.php';

// Route for example page of template
// require __DIR__ . '/template.php';