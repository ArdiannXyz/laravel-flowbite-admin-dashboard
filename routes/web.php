<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WarehouseDashboardController;
use App\Http\Controllers\StaffDashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\StockOutController;
use App\Http\Controllers\StockOpnameController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes - Stockify Inventory Core System
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {

    // =========================================================================
    // 1. REDIRECT DASHBOARD UTAMA BERDASARKAN ROLE
    // =========================================================================
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return app(DashboardController::class)->index();
        }

        if ($user->hasRole('manajer')) {
            return redirect()->route('warehouse.dashboard');
        }

        if ($user->hasRole('staff')) {
            return redirect()->route('dashboard-staff.index');
        }

        abort(403, 'Akun Anda belum memiliki role yang valid.');
    })->name('dashboard');

    // =========================================================================
    // 2. TARGET ROUTE DASHBOARD KHUSUS ROLE
    // =========================================================================
    Route::middleware(['role:manajer'])->group(function () {
        Route::get('/warehouse/dashboard', [WarehouseDashboardController::class, 'index'])->name('warehouse.dashboard');
    });

    Route::middleware(['role:staff'])->group(function () {
        Route::get('/dashboard-staff', [StaffDashboardController::class, 'index'])->name('dashboard-staff.index');
    });

    // =========================================================================
    // 3. AKSES BERSAMA (Admin, Manajer, Staff)
    // =========================================================================
    Route::middleware(['role:admin|manajer|staff'])->group(function () {
        
        // Stok Masuk
        Route::get('stock-in', [StockInController::class, 'index'])->name('stock-in.index');
        Route::get('stock-in/{id}', [StockInController::class, 'show'])->name('stock-in.show');
        Route::post('stock-in/{id}/confirm', [StockInController::class, 'confirm'])->name('stock-in.confirm');

        // Stok Keluar
        Route::get('stock-out', [StockOutController::class, 'index'])->name('stock-out.index');
        Route::get('stock-out/{id}', [StockOutController::class, 'show'])->name('stock-out.show');
        Route::post('stock-out/{id}/confirm', [StockOutController::class, 'confirm'])->name('stock-out.confirm');
    });

    // =========================================================================
    // 4. AKSES MANAJERIAL (Admin & Manajer Gudang)
    // =========================================================================
    Route::middleware(['role:admin|manajer'])->group(function () {
        
        // Produk
        Route::get('products', [ProductController::class, 'index'])->name('products.index');

        // Transaksi Stock
        Route::get('stock-in/create', [StockInController::class, 'create'])->name('stock-in.create');
        Route::post('stock-in', [StockInController::class, 'store'])->name('stock-in.store');
        
        Route::get('stock-out/create', [StockOutController::class, 'create'])->name('stock-out.create');
        Route::post('stock-out', [StockOutController::class, 'store'])->name('stock-out.store');

        // Stock Opname
        Route::get('stock-opname', [StockOpnameController::class, 'index'])->name('stock-opname.index');
        Route::get('stock-opname/create', [StockOpnameController::class, 'create'])->name('stock-opname.create');
        Route::post('stock-opname', [StockOpnameController::class, 'store'])->name('stock-opname.store');

        // // Supplier
        // Route::get('suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
        // Route::get('suppliers/{supplier}', [SupplierController::class, 'show'])->name('suppliers.show');

        // Laporan
        Route::get('/report', [ReportController::class, 'index'])->name('report.index');
    });

    // =========================================================================
    // 5. KHUSUS ADMIN SYSTEM
    // =========================================================================
    Route::middleware(['role:admin'])->group(function () {
        
        // Produk CUD & Import/Export
        Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('products', [ProductController::class, 'store'])->name('products.store');
        Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

        // Master Data Kategori
        Route::resource('categories', CategoryController::class)->except(['show']);
    });

    // Route Detail Produk untuk Admin & Manajer
    Route::middleware(['role:admin|manajer'])->group(function () {
        Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');
    });

    // =========================================================================
    // 6. PROFILE
    // =========================================================================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';