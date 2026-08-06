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
use App\Http\Controllers\GlobalSearchController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StockSettingController;

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
    // 1. GLOBAL & PROFILE
    // =========================================================================
    Route::get('/search', [GlobalSearchController::class, 'index'])->name('search.global');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // =========================================================================
    // 2. REDIRECT DASHBOARD UTAMA
    // =========================================================================
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->hasRole('admin')) return app(DashboardController::class)->index();
        if ($user->hasRole('manajer')) return redirect()->route('warehouse.dashboard');
        if ($user->hasRole('staff')) return redirect()->route('dashboard-staff.index');

        abort(403, 'Akun Anda belum memiliki role yang valid.');
    })->name('dashboard');

    // =========================================================================
    // 3. AKSES STAFF GUDANG
    // =========================================================================
    Route::middleware(['role:staff'])->group(function () {
        Route::get('/dashboard-staff', [StaffDashboardController::class, 'index'])->name('dashboard-staff.index');
        
        // Konfirmasi/Tolak Transaksi
        Route::post('stock-in/{stockTransaction}/confirm', [StockInController::class, 'confirm'])->name('stock-in.confirm');
        Route::post('stock-in/{stockTransaction}/reject', [StockInController::class, 'reject'])->name('stock-in.reject');
        Route::post('stock-out/{stockTransaction}/confirm', [StockOutController::class, 'confirm'])->name('stock-out.confirm');
        Route::post('stock-out/{stockTransaction}/reject', [StockOutController::class, 'reject'])->name('stock-out.reject');
    });

    // =========================================================================
    // 4. AKSES BERSAMA (Admin, Manajer, Staff)
    // =========================================================================
    Route::middleware(['role:admin|manajer|staff'])->group(function () {
        // Hanya bisa melihat daftar Riwayat Barang
        Route::get('stock-in', [StockInController::class, 'index'])->name('stock-in.index');
        Route::get('stock-out', [StockOutController::class, 'index'])->name('stock-out.index');
    });

    // =========================================================================
    // 5. ADMIN & MANAJER (Akses Bersama) - ROUTE STATIS
    // =========================================================================
    Route::middleware(['role:admin|manajer'])->group(function () {
        Route::get('/warehouse/dashboard', [WarehouseDashboardController::class, 'index'])->name('warehouse.dashboard');

        // Master Data Read-Only
        Route::get('products', [ProductController::class, 'index'])->name('products.index');
        Route::get('suppliers', [SupplierController::class, 'index'])->name('suppliers.index');

        // Form Transaksi
        Route::get('stock-in/create', [StockInController::class, 'create'])->name('stock-in.create');
        Route::post('stock-in', [StockInController::class, 'store'])->name('stock-in.store');
        Route::get('stock-out/create', [StockOutController::class, 'create'])->name('stock-out.create');
        Route::post('stock-out', [StockOutController::class, 'store'])->name('stock-out.store');

        // Stock Opname
        Route::get('stock-opname', [StockOpnameController::class, 'index'])->name('stock-opname.index');
        Route::get('stock-opname/create', [StockOpnameController::class, 'create'])->name('stock-opname.create');
        Route::post('stock-opname', [StockOpnameController::class, 'store'])->name('stock-opname.store');

        // Laporan
        Route::get('/report', [ReportController::class, 'index'])->name('report.index');
        Route::get('/report/export/stok', [ReportController::class, 'exportStokPdf'])->name('report.export.stok');
        Route::get('/report/export/stok-excel', [ReportController::class, 'exportStokExcel'])->name('report.export.stok-excel');
        Route::get('/report/export/masuk', [ReportController::class, 'exportBarangMasukPdf'])->name('report.export.masuk');
        Route::get('/report/export/masuk-excel', [ReportController::class, 'exportBarangMasukExcel'])->name('report.export.masuk-excel');
        Route::get('/report/export/keluar', [ReportController::class, 'exportBarangKeluarPdf'])->name('report.export.keluar');
        Route::get('/report/export/keluar-excel', [ReportController::class, 'exportBarangKeluarExcel'])->name('report.export.keluar-excel');
        Route::get('/report/export/aktivitas', [ReportController::class, 'exportAktivitasPdf'])->name('report.export.aktivitas');
        Route::get('/report/export/aktivitas-excel', [ReportController::class, 'exportAktivitasExcel'])->name('report.export.aktivitas-excel');
    });

    // =========================================================================
    // 6. KHUSUS ADMIN - ROUTE STATIS & MANIPULASI
    // =========================================================================
    Route::middleware(['role:admin'])->group(function () {
        // Produk
        Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('products', [ProductController::class, 'store'])->name('products.store');
        Route::get('products/import', [ProductController::class, 'import'])->name('products.import');
        Route::post('products/import', [ProductController::class, 'storeImport'])->name('products.storeImport');
        Route::get('products/export', [ProductController::class, 'export'])->name('products.export');

        // Supplier
        Route::get('suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
        Route::post('suppliers', [SupplierController::class, 'store'])->name('suppliers.store');

        // Master Data & Setting
        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::resource('attributes', AttributeController::class)->except(['show']);
        Route::resource('users', UserController::class)->except(['show']);
        
        Route::get('stock-settings', [StockSettingController::class, 'index'])->name('stock-settings.index');
        Route::put('stock-settings', [StockSettingController::class, 'update'])->name('stock-settings.update');
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    });

    // =========================================================================
    // 7. ROUTE WILDCARD (Show, Edit, Update, Destroy) 
    // Harus diletakkan di bawah agar tidak menimpa route /create atau /export
    // =========================================================================

    // Admin & Manajer (Read-Only Detail)
    Route::middleware(['role:admin|manajer'])->group(function () {
        Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');
        Route::get('suppliers/{supplier}', [SupplierController::class, 'show'])->name('suppliers.show');
    });

    // Khusus Admin (Edit & Hapus)
    Route::middleware(['role:admin'])->group(function () {
        Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

        Route::get('suppliers/{supplier}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
        Route::put('suppliers/{supplier}', [SupplierController::class, 'update'])->name('suppliers.update');
        Route::delete('suppliers/{supplier}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');
    });

});

require __DIR__.'/auth.php';