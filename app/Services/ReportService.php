<?php

namespace App\Services;

use App\Models\Product;
use App\Models\StockTransaction;
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

        // 2. Ringkasan Stok
        $totalProducts   = $this->productRepository->countTotalProducts();
        $lowStockCount   = $this->productRepository->countLowStockProducts();
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

    public function getStokProductsForExport(Request $request)
    {
        $query = Product::with(['category', 'supplier'])->latest('id');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->stock_status === 'menipis') {
            $query->whereColumn('current_stock', '<', 'min_stock');
        } elseif ($request->stock_status === 'aman') {
            $query->whereColumn('current_stock', '>=', 'min_stock');
        }

        return $query->get();
    }

    public function getBarangMasukForExport(Request $request)
    {
        $query = StockTransaction::with(['product', 'supplier', 'user'])
            ->where('type', 'in');

        if ($request->filled('masuk_from_date')) {
            $query->whereDate('transaction_date', '>=', $request->masuk_from_date);
        }
        if ($request->filled('masuk_to_date')) {
            $query->whereDate('transaction_date', '<=', $request->masuk_to_date);
        }

        return $query->latest('id')->get();
    }

    public function getBarangKeluarForExport(Request $request)
    {
        $query = StockTransaction::with(['product', 'user'])
            ->where('type', 'out');

        if ($request->filled('keluar_from_date')) {
            $query->whereDate('transaction_date', '>=', $request->keluar_from_date);
        }
        if ($request->filled('keluar_to_date')) {
            $query->whereDate('transaction_date', '<=', $request->keluar_to_date);
        }

        return $query->latest('id')->get();
    }

    public function getAktivitasForExport(Request $request)
    {
        $query = StockTransaction::with(['product', 'user']);

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->filled('act_from_date')) {
            $query->whereDate('transaction_date', '>=', $request->act_from_date);
        }
        if ($request->filled('act_to_date')) {
            $query->whereDate('transaction_date', '<=', $request->act_to_date);
        }

        return $query->latest('id')->get();
    }
}