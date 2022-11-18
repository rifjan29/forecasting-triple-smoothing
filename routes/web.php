<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransaksiPenjualanController;
use App\Http\Controllers\TransaksiPurchaseOrderController;
use App\Http\Controllers\TransaksiProfitController;
use App\Http\Controllers\ForecastingPurchaseOrderController;
use App\Http\Controllers\ForecastingProfitController;
use App\Http\Controllers\LaporanPurchaseOrderController;
use App\Http\Controllers\LaporanProfitController;
use App\Http\Controllers\LaporanPenjualanController;
use App\Http\Controllers\DashboardController;

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

Route::get('/total-penjualan', [DashboardController::class,'TotalPenjualan'])->name('total.penjualan');

Route::get('/total-profit', [DashboardController::class,'TotalProfit'])->name('total.profit');

Route::get('/totalpo',[DashboardController::class,'TotalPurchaseOrder'])->name('total.po');

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('master/satuan',SatuanController::class);

    Route::resource('master/barang',BarangController::class);

    Route::resource('master/user',UserController::class);

    Route::resource('transaksi/penjualan',TransaksiPenjualanController::class);

    Route::resource('transaksi/purchase-order',TransaksiPurchaseOrderController::class);

    Route::resource('transaksi/profit', TransaksiProfitController::class);

    Route::resource('peramalan/forecast-purchase-order', ForecastingPurchaseOrderController::class);

    Route::resource('peramalan/forecast-profit', ForecastingProfitController::class);

    Route::resource('laporan/report-purchase-order', LaporanPurchaseOrderController::class);

    Route::resource('laporan/report-profit', LaporanProfitController::class);

    Route::resource('laporan/report-penjualan', LaporanPenjualanController::class);

});

require __DIR__.'/auth.php';
