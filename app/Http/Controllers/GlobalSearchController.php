<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\StockTransaction;
use App\Models\StockOpname;

class GlobalSearchController extends Controller
{
    // Daftar menu/fitur yang bisa dicari
    private array $menus = [
        ['label' => 'Dashboard Gudang',     'url' => '/warehouse/dashboard',  'icon' => 'dashboard',  'category' => 'Halaman'],
        ['label' => 'Dashboard Staff',      'url' => '/dashboard-staff',      'icon' => 'dashboard',  'category' => 'Halaman'],
        ['label' => 'Laporan',              'url' => '/report',               'icon' => 'report',     'category' => 'Halaman'],
        ['label' => 'Daftar Produk',        'url' => '/products',             'icon' => 'product',    'category' => 'Manajemen Produk'],
        ['label' => 'Tambah Produk',        'url' => '/products/create',      'icon' => 'add',        'category' => 'Manajemen Produk'],
        ['label' => 'Daftar Supplier',      'url' => '/suppliers',            'icon' => 'product',    'category' => 'Supplier'],
        ['label' => 'Riwayat Barang Masuk', 'url' => '/stock-in',             'icon' => 'stock-in',   'category' => 'Barang Masuk'],
        ['label' => 'Catat Barang Masuk',   'url' => '/stock-in/create',      'icon' => 'add',        'category' => 'Barang Masuk'],
        ['label' => 'Riwayat Barang Keluar','url' => '/stock-out',            'icon' => 'stock-out',  'category' => 'Barang Keluar'],
        ['label' => 'Catat Barang Keluar',  'url' => '/stock-out/create',     'icon' => 'add',        'category' => 'Barang Keluar'],
        ['label' => 'Riwayat Stock Opname', 'url' => '/stock-opname',         'icon' => 'opname',     'category' => 'Stock Opname'],
        ['label' => 'Buat Stock Opname',    'url' => '/stock-opname/create',  'icon' => 'add',        'category' => 'Stock Opname'],
    ];

    public function search(Request $request)
    {
        $query = trim($request->get('q', ''));

        if (strlen($query) < 2) {
            return response()->json(['results' => [], 'query' => $query]);
        }

        $results = [];

        // 1. Cari Menu/Fitur
        foreach ($this->menus as $menu) {
            if (stripos($menu['label'], $query) !== false || stripos($menu['category'], $query) !== false) {
                $results[] = [
                    'type'     => 'menu',
                    'icon'     => $menu['icon'],
                    'category' => $menu['category'],
                    'title'    => $menu['label'],
                    'subtitle' => $menu['category'],
                    'url'      => $menu['url'],
                    'badge'    => null,
                ];
            }
        }

        // 2. Cari Produk
        $products = Product::with('category')
            ->where('name', 'like', "%{$query}%")
            ->orWhere('sku', 'like', "%{$query}%")
            ->orWhereHas('category', fn($q) => $q->where('name', 'like', "%{$query}%"))
            ->limit(5)
            ->get();

        foreach ($products as $product) {
            $stockStatus = $product->isLowStock() ? 'Stok Menipis' : 'Stok Aman';
            $results[] = [
                'type'     => 'product',
                'icon'     => 'product',
                'category' => 'Produk',
                'title'    => $product->name,
                'subtitle' => 'SKU: ' . $product->sku . ' | Stok: ' . $product->current_stock . ' ' . $product->unit,
                'url'      => '/products/' . $product->id,
                'badge'    => $product->isLowStock() ? 'low-stock' : null,
                'badge_text' => $stockStatus,
            ];
        }

        // 3. Cari Transaksi (Barang Masuk & Keluar)
        $transactions = StockTransaction::with('product')
            ->where('transaction_code', 'like', "%{$query}%")
            ->orWhereHas('product', fn($q) => $q->where('name', 'like', "%{$query}%"))
            ->orWhere('notes', 'like', "%{$query}%")
            ->limit(5)
            ->get();

        foreach ($transactions as $trx) {
            $isIn  = $trx->type === 'in';
            $results[] = [
                'type'     => 'transaction',
                'icon'     => $isIn ? 'stock-in' : 'stock-out',
                'category' => $isIn ? 'Barang Masuk' : 'Barang Keluar',
                'title'    => $trx->transaction_code,
                'subtitle' => ($trx->product->name ?? '-') . ' | ' . ($isIn ? '+' : '-') . $trx->quantity . ' ' . ($trx->product->unit ?? 'pcs'),
                'url'      => $isIn ? '/stock-in' : '/stock-out',
                'badge'    => $isIn ? 'in' : 'out',
                'badge_text' => $isIn ? 'MASUK' : 'KELUAR',
            ];
        }

        // 4. Cari Stock Opname
        $opnames = StockOpname::with('product')
            ->where('opname_code', 'like', "%{$query}%")
            ->orWhereHas('product', fn($q) => $q->where('name', 'like', "%{$query}%"))
            ->limit(3)
            ->get();

        foreach ($opnames as $opname) {
            $results[] = [
                'type'     => 'opname',
                'icon'     => 'opname',
                'category' => 'Stock Opname',
                'title'    => $opname->opname_code,
                'subtitle' => ($opname->product->name ?? '-') . ' | Selisih: ' . ($opname->difference ?? 0),
                'url'      => '/stock-opname',
                'badge'    => null,
            ];
        }

        return response()->json([
            'query'   => $query,
            'count'   => count($results),
            'results' => $results,
        ]);
    }
}
