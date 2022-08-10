<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ObatController;
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
});

require __DIR__.'/auth.php';
