<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WarehouseDashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\StockOutController;
use App\Http\Controllers\StockOpnameController;

/*
|--------------------------------------------------------------------------
| Web Routes - Stockify Inventory Core System
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('warehouse.dashboard');
});

// Warehouse Manager Dashboard
Route::get('/warehouse/dashboard', [WarehouseDashboardController::class, 'index'])->name('warehouse.dashboard');

// Product Management (CRUD)
Route::resource('products', ProductController::class);

// Barang Masuk (Stock In)
Route::get('stock-in', [StockInController::class, 'index'])->name('stock-in.index');
Route::get('stock-in/create', [StockInController::class, 'create'])->name('stock-in.create');
Route::post('stock-in', [StockInController::class, 'store'])->name('stock-in.store');

// Barang Keluar (Stock Out)
Route::get('stock-out', [StockOutController::class, 'index'])->name('stock-out.index');
Route::get('stock-out/create', [StockOutController::class, 'create'])->name('stock-out.create');
Route::post('stock-out', [StockOutController::class, 'store'])->name('stock-out.store');

// Stock Opname
Route::get('stock-opname', [StockOpnameController::class, 'index'])->name('stock-opname.index');
Route::get('stock-opname/create', [StockOpnameController::class, 'create'])->name('stock-opname.create');
Route::post('stock-opname', [StockOpnameController::class, 'store'])->name('stock-opname.store');
