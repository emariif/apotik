<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\StockObatController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\SatuanController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::group(['middleware' => ['role:owner']], function() {
    Route::get('supplier.index', [SupplierController::class, 'index'])->name('supplier.index');
    Route::post('supplier.store', [SupplierController::class, 'store'])->name('supplier.store');
    Route::post('supplier.edits', [SupplierController::class, 'edits'])->name('supplier.edits');
    Route::post('supplier.updates', [SupplierController::class, 'updates'])->name('supplier.updates');
    Route::post('supplier.hapus', [SupplierController::class, 'hapus'])->name('supplier.hapus');

    Route::get('obat.index', [ObatController::class, 'index'])->name('obat.index');
    Route::post('obat.store', [ObatController::class, 'store'])->name('obat.store');
    Route::post('obat.edits', [ObatController::class, 'edits'])->name('obat.edits');
    Route::post('obat.updates', [ObatController::class, 'updates'])->name('obat.updates');
    Route::post('obat.hapus', [ObatController::class, 'hapus'])->name('obat.hapus');

    Route::get('stocks.index', [StockObatController::class, 'index'])->name('stocks.index');
    Route::post('stocks.store', [StockObatController::class, 'store'])->name('stocks.store');
    Route::post('getObat', [StockObatController::class, 'getObat'])->name('getObat');
    Route::post('stocks.edits', [StockObatController::class, 'edits'])->name('stocks.edits');
    Route::post('stocks.updates', [StockObatController::class, 'updates'])->name('stocks.updates');
    Route::post('stocks.hapus', [StockObatController::class, 'hapus'])->name('stocks.hapus');

    Route::resource('penjualan', PenjualanController::class);
    // Route::get('penjualan.index', [PenjualanController::class, 'index'])->name('penjualan.index');
    // Route::post('penjualan.store', [PenjualanController::class, 'store'])->name('penjualan.store');
    Route::get('penjualan.dataTable', [PenjualanController::class, 'dataTable'])->name('dataTable');
    Route::post('penjualan.hapus', [PenjualanController::class, 'hapus'])->name('hapusOrder');

    Route::post('penjualan.store', [PembayaranController::class, 'store'])->name('simpanPenjualan');
    
    Route::post('penjualan.cetak', [PenjualanController::class, 'cetakNota'])->name('cetakNota');
    Route::get('penjualan.cetak', [PenjualanController::class, 'cetakNota'])->name('cetakNota');
    Route::get('download', [PenjualanController::class, 'download'])->name('downloadPDF');

    Route::get('generate-pdf', [SatuanController::class, 'generatePdf'])->name('generate');
}); 

require __DIR__.'/auth.php';
