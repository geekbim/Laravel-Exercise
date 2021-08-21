<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// home
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// topup
Route::get('/topup', [App\Http\Controllers\TopupController::class, 'index'])->name('topup');
Route::post('/topup', [App\Http\Controllers\TopupController::class, 'store'])->name('topup.store');
// product
Route::get('/order', [App\Http\Controllers\OrderController::class, 'index'])->name('order');
Route::post('/order', [App\Http\Controllers\OrderController::class, 'store'])->name('order.store');
Route::get('/order/success/{noOrder}', [App\Http\Controllers\OrderController::class, 'success'])->name('order.success');
// order
Route::get('/order/pay/{noOrder}', [App\Http\Controllers\OrderController::class, 'payPage'])->name('order.payPage');
Route::post('/order/pay/{noOrder}', [App\Http\Controllers\OrderController::class, 'pay'])->name('order.pay');
Route::get('/history', [App\Http\Controllers\HistoryController::class, 'index'])->name('history');