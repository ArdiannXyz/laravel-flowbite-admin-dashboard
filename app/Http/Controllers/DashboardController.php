<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 0. Auto-konfirmasi transaksi pending yang dibuat oleh Admin/Manajer
        $pendingTransactions = StockTransaction::where('status', 'pending')->get();
        foreach ($pendingTransactions as $trx) {
            $user = $trx->user_id ? User::find($trx->user_id) : null;
            if (!$user || $user->hasRole('admin') || $user->hasRole('manajer') || ($user->role ?? '') === 'admin' || ($user->role ?? '') === 'manajer') {
                try {
                    if ($trx->type === 'out') {
                        app(\App\Services\StockOutService::class)->confirmStockOut($trx, $trx->user_id ?? 1);
                    } else if ($trx->type === 'in') {
                        app(\App\Services\StockInService::class)->confirmStockIn($trx, $trx->user_id ?? 1);
                    }
                } catch (\Throwable $e) {
                    // abaikan jika stok tidak mencukupi saat ini
                }
            }
        }

        // 1. Ringkasan Statistik untuk Card Dashboard
        $totalProducts = Product::count();
        
        // Transaksi Barang Masuk & Keluar (yang dikonfirmasi)
        $totalStockIn = StockTransaction::where('type', 'in')->where('status', 'confirmed')->sum('quantity');
        $totalStockOut = StockTransaction::where('type', 'out')->where('status', 'confirmed')->sum('quantity');

        // 2. Produk Stok Menipis (Peringatan Stok Minimum)
        $lowStockProducts = Product::whereColumn('current_stock', '<=', 'min_stock')
            ->limit(5)
            ->get();

        // 3. Aktivitas Transaksi Terakhir (Aktivitas Pengguna Terbaru)
        $recentTransactions = StockTransaction::with(['product', 'user'])
            ->latest()
            ->limit(7)
            ->get();

        // 4. Data Grafik Stok Barang per Kategori
        $categoryChartData = Category::withCount('products')
            ->withSum('products', 'current_stock')
            ->get()
            ->map(function ($cat) {
                return [
                    'name' => $cat->name,
                    'stock' => (int) ($cat->products_sum_current_stock ?? 0),
                ];
            });

        return view('dashboard', compact(
            'totalProducts',
            'totalStockIn',
            'totalStockOut',
            'lowStockProducts',
            'recentTransactions',
            'categoryChartData'
        ));
    }
}