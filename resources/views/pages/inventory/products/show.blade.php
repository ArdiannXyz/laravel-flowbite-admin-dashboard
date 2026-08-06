@extends('layouts.dashboard')

@section('content')
<div class="px-4 pt-6">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Detail Produk: {{ $product->name }}</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Informasi lengkap, riwayat stok, dan transaksi produk ini.</p>
        </div>
        <div class="flex items-center gap-2">
            @role('admin')
                <a href="{{ route('products.edit', $product->id) }}" class="rounded-lg bg-blue-700 px-4 py-2 text-sm font-medium text-white hover:bg-blue-800 dark:bg-blue-600 dark:hover:bg-blue-700">
                    Edit Produk
                </a>
            @endrole
            <a href="{{ route('products.index') }}" class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                ← Kembali
            </a>
        </div>
    </div>

    <!-- Product Card Overview -->
    <div class="mb-6 grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" class="h-48 w-full rounded-lg object-cover border mb-4" alt="{{ $product->name }}">
            @else
                <div class="flex h-48 w-full items-center justify-center rounded-lg bg-gray-100 text-gray-400 dark:bg-gray-700 mb-4">
                    <svg class="h-16 w-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
            @endif

            <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $product->name }}</h2>
            <p class="font-mono text-sm text-gray-500 dark:text-gray-400 mb-4">SKU: {{ $product->sku }}</p>

            <div class="space-y-3 text-sm">
                <div class="flex justify-between border-b pb-2 dark:border-gray-700">
                    <span class="text-gray-500 dark:text-gray-400">Kategori:</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $product->category->name ?? '-' }}</span>
                </div>
                <div class="flex justify-between border-b pb-2 dark:border-gray-700">
                    <span class="text-gray-500 dark:text-gray-400">Supplier:</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $product->supplier->name ?? '-' }}</span>
                </div>
                <div class="flex justify-between border-b pb-2 dark:border-gray-700">
                    <span class="text-gray-500 dark:text-gray-400">Harga Beli (AVG):</span>
                    <div class="text-right">
                        <span class="font-semibold text-gray-900 dark:text-white">Rp {{ number_format($product->buy_price, 0, ',', '.') }}</span>
                        <div class="text-[10px] text-gray-400">Weighted Average Cost</div>
                    </div>
                </div>
                <div class="flex justify-between border-b pb-2 dark:border-gray-700">
                    <span class="text-gray-500 dark:text-gray-400">Harga Jual:</span>
                    <span class="font-semibold text-gray-900 dark:text-white">Rp {{ number_format($product->sell_price, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Stock Status Card -->
        <div class="lg:col-span-2 space-y-6">
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Status & Alokasi Stok</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                    <div class="rounded-lg bg-gray-50 p-4 dark:bg-gray-700/50">
                        <p class="text-xs text-gray-500 dark:text-gray-400">Stok Fisik Saat Ini</p>
                        <h4 class="text-2xl font-extrabold text-gray-900 dark:text-white mt-1">{{ $product->current_stock }} {{ $product->unit }}</h4>
                    </div>
                    <div class="rounded-lg bg-gray-50 p-4 dark:bg-gray-700/50">
                        <p class="text-xs text-gray-500 dark:text-gray-400">Batas Stok Minimum</p>
                        <h4 class="text-2xl font-extrabold text-amber-600 dark:text-amber-400 mt-1">{{ $product->min_stock }} {{ $product->unit }}</h4>
                    </div>
                    <div class="rounded-lg bg-gray-50 p-4 dark:bg-gray-700/50">
                        <p class="text-xs text-gray-500 dark:text-gray-400">Status Kondisi</p>
                        <div class="mt-1">
                            @if($product->isLowStock())
                                <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-bold text-amber-800 dark:bg-amber-900 dark:text-amber-300">
                                    Stok Menipis (Restock Required)
                                </span>
                            @else
                                <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-bold text-green-800 dark:bg-green-900 dark:text-green-300">
                                    Stok Aman
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('stock-in.create', ['product_id' => $product->id]) }}" class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700">
                        + Tambah Barang Masuk
                    </a>
                    <a href="{{ route('stock-out.create', ['product_id' => $product->id]) }}" class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700">
                        - Catat Barang Keluar
                    </a>
                    <a href="{{ route('stock-opname.create', ['product_id' => $product->id]) }}" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                        Cek Stock Opname
                    </a>
                </div>
            </div>

            <!-- Transaction History Log for this product -->
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Riwayat Mutasi Stok Produk</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th class="px-4 py-3">Tanggal</th>
                                <th class="px-4 py-3">Kode TRX</th>
                                <th class="px-4 py-3">Tipe</th>
                                <th class="px-4 py-3 text-center">Jumlah</th>
                                <th class="px-4 py-3">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($product->stockTransactions as $trx)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <td class="px-4 py-3 text-xs">{{ $trx->transaction_date->format('d/m/Y') }}</td>
                                    <td class="px-4 py-3 font-mono text-xs">{{ $trx->transaction_code }}</td>
                                    <td class="px-4 py-3">
                                        @if($trx->type === 'in')
                                            <span class="rounded-md bg-green-100 px-2 py-0.5 text-xs font-bold text-green-800 dark:bg-green-900 dark:text-green-300">MASUK</span>
                                        @else
                                            <span class="rounded-md bg-blue-100 px-2 py-0.5 text-xs font-bold text-blue-800 dark:bg-blue-900 dark:text-blue-300">KELUAR</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center font-bold {{ $trx->type === 'in' ? 'text-green-600' : 'text-blue-600' }}">
                                        {{ $trx->type === 'in' ? '+' : '-' }}{{ $trx->quantity }} {{ $product->unit }}
                                    </td>
                                    <td class="px-4 py-3 text-xs text-gray-500">{{ $trx->notes ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-6 text-center text-gray-500 dark:text-gray-400">Belum ada riwayat mutasi stok.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
