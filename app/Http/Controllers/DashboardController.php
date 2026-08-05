<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockTransaction; // Sesuaikan dengan nama model transaksi Anda
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ringkasan Statistik untuk Card Dashboard
        $totalProducts = Product::count();
        
        // Transaksi Barang Masuk & Keluar
        $totalStockIn = StockTransaction::where('type', 'in')->sum('quantity');
        $totalStockOut = StockTransaction::where('type', 'out')->sum('quantity');

        // 2. Produk Stok Menipis (Peringatan Stok Minimum)
        $lowStockProducts = Product::whereColumn('current_stock', '<=', 'min_stock')
            ->limit(5)
            ->get();

        // 3. Aktivitas Transaksi Terakhir
        $recentTransactions = StockTransaction::with(['product', 'user'])
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalProducts',
            'totalStockIn',
            'totalStockOut',
            'lowStockProducts',
            'recentTransactions'
        ));
    }
}