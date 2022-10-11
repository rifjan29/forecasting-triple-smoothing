<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\UserController;

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
    return view('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::resource('master/satuan',SatuanController::class);

Route::resource('master/barang',BarangController::class);

Route::resource('master/user',UserController::class);

// Route::middleware(['auth'])->group(function () {
//     Route::prefix('administrator')->group(function () {
//         Route::get('/',[HomeController::class,'index'])->name('home');




//     });
// });

require __DIR__.'/auth.php';
