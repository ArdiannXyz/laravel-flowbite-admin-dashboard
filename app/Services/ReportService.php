<?php

namespace App\Services;

use App\Models\Product;
use App\Models\User;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\StockTransactionRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportService
{
    public function __construct(
        protected ProductRepositoryInterface $productRepository,
        protected StockTransactionRepositoryInterface $stockTransactionRepository,
        protected CategoryRepositoryInterface $categoryRepository
    ) {}

    public function getReportData(Request $request): array
    {
        // 1. Data Dropdown Filter
        $categories = $this->categoryRepository->getAll();
        $users      = User::orderBy('name', 'asc')->get();

        // 2. Ringkasan Stok (Memanggil method yang ADA di ProductRepositoryInterface)
        $totalProducts   = $this->productRepository->countTotalProducts();
        $lowStockCount   = $this->productRepository->countLowStockProducts();

        // Total Nilai Stok dihitung langsung dari Model Product
        $totalStockValue = (float) Product::sum(DB::raw('current_stock * buy_price'));

        // 3. Tab 1: Data Produk untuk Laporan Stok
        $stokFilters = [];
        if ($request->filled('category_id')) {
            $stokFilters['category_id'] = $request->category_id;
        }
        if ($request->stock_status === 'menipis') {
            $stokFilters['low_stock'] = true;
        }

        $stokProducts = $this->productRepository->getAllPaginated($stokFilters, 10);

        // 4. Tab 2: Barang Masuk
        $barangMasuk = $this->stockTransactionRepository->getByTypePaginated('in', [
            'date_from' => $request->masuk_from_date,
            'date_to'   => $request->masuk_to_date,
        ], 10);

        // 5. Tab 3: Barang Keluar
        $barangKeluar = $this->stockTransactionRepository->getByTypePaginated('out', [
            'date_from' => $request->keluar_from_date,
            'date_to'   => $request->keluar_to_date,
        ], 10);

        // 6. Tab 4: Aktivitas Pengguna
        $userActivities = $this->stockTransactionRepository->getAllPaginated([
            'user_id'   => $request->user_id,
            'date_from' => $request->act_from_date,
            'date_to'   => $request->act_to_date,
        ], 10);

        return compact(
            'categories',
            'users',
            'totalProducts',
            'totalStockValue',
            'lowStockCount',
            'stokProducts',
            'barangMasuk',
            'barangKeluar',
            'userActivities'
        );
    }

    // ==========================================================================
    // METHOD EXPORT PDF — mengambil data TANPA pagination (semua baris sekaligus)
    // ==========================================================================

    /**
     * Data untuk export Laporan Stok — menghormati filter category_id & stock_status
     * yang sedang aktif di halaman (kalau ada).
     */
    public function exportStok(Request $request)
    {
        $filters = [];

        if ($request->filled('category_id')) {
            $filters['category_id'] = $request->category_id;
        }

        if ($request->stock_status === 'menipis') {
            $filters['low_stock'] = true;
        }

        return $this->productRepository->getAllForExport($filters);
    }

    /**
     * Data untuk export Laporan Barang Masuk.
     */
    public function exportBarangMasuk(Request $request)
    {
        return $this->stockTransactionRepository->getByTypeForExport('in', [
            'date_from' => $request->masuk_from_date,
            'date_to'   => $request->masuk_to_date,
        ]);
    }

    /**
     * Data untuk export Laporan Barang Keluar.
     */
    public function exportBarangKeluar(Request $request)
    {
        return $this->stockTransactionRepository->getByTypeForExport('out', [
            'date_from' => $request->keluar_from_date,
            'date_to'   => $request->keluar_to_date,
        ]);
    }

    /**
     * Data untuk export Aktivitas Pengguna.
     *
     * CATATAN: sama seperti di getReportData di atas, ini mengambil dari
     * stock_transactions (bukan tabel log aktivitas terpisah). Jadi export ini
     * hanya mencakup aktivitas transaksi stok, bukan aktivitas lain seperti login.
     */
    public function exportAktivitas(Request $request)
    {
        return $this->stockTransactionRepository->getAllForExport([
            'user_id'   => $request->user_id,
            'date_from' => $request->act_from_date,
            'date_to'   => $request->act_to_date,
        ]);
    }
}