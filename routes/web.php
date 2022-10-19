<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransaksiPenjualanController;
use App\Http\Controllers\TransaksiPurchaseOrderController;
use App\Http\Controllers\TransaksiProfitController;


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

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {return view('dashboard');})->name('dashboard');

    Route::get('/', function () {
    return view('dashboard');
    });
    Route::resource('master/satuan',SatuanController::class);

    Route::resource('master/barang',BarangController::class);

    Route::resource('master/user',UserController::class);

    Route::resource('transaksi/penjualan',TransaksiPenjualanController::class);

    Route::resource('transaksi/purchase-order',TransaksiPurchaseOrderController::class);

    Route::resource('transaksi/profit', TransaksiProfitController::class);

});

require __DIR__.'/auth.php';
