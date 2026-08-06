@extends('layouts.dashboard')

@section('content')
<div class="px-4 pt-6 pb-8">
    <!-- Header Page -->
    <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white flex items-center gap-3">
                Hasil Pencarian 
                @if(!empty($query))
                    <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                        {{ $totalResults }} Ditemukan
                    </span>
                @endif
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                @if(!empty($query))
                    Hasil pencarian untuk kata kunci <strong class="text-gray-900 dark:text-white">"{{ $query }}"</strong> di seluruh entitas sistem.
                @else
                    Masukkan kata kunci pencarian pada form di bawah ini.
                @endif
            </p>
        </div>
    </div>

    <!-- Global Search Input Bar -->
    <div class="mb-6 rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <form method="GET" action="{{ route('search.global') }}" class="flex flex-col gap-3 sm:flex-row">
            <div class="relative flex-1">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text" name="q" value="{{ $query }}" placeholder="Cari nama produk, SKU, kode TRX, supplier, atau kategori..." class="w-full rounded-lg border border-gray-300 bg-gray-50 p-3 pl-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400">
            </div>
            <button type="submit" class="rounded-lg bg-blue-700 px-6 py-3 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700">
                Cari Sistem
            </button>
        </form>
    </div>

    @if(empty($query))
        <div class="rounded-xl border border-gray-200 bg-white p-12 text-center shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <h3 class="mt-3 text-lg font-bold text-gray-900 dark:text-white">Ketik kata kunci untuk memulai pencarian</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Anda dapat mencari Produk (SKU/Nama), Transaksi Stok (Kode TRX), Supplier, atau Kategori Produk.</p>
        </div>
    @elseif($totalResults === 0)
        <div class="rounded-xl border border-gray-200 bg-white p-12 text-center shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <svg class="mx-auto h-12 w-12 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <h3 class="mt-3 text-lg font-bold text-gray-900 dark:text-white">Tidak ada hasil ditemukan</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Tidak ada data yang cocok dengan kata kunci <strong>"{{ $query }}"</strong>. Silakan coba kata kunci lain.</p>
        </div>
    @else
        <div class="space-y-8">
            <!-- 1. HAK HASIL: PRODUK (BARANG) -->
            @if($products->isNotEmpty())
                <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <div class="mb-4 flex items-center justify-between">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            📦 Produk / Barang
                            <span class="rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-bold text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                {{ $products->count() }}
                            </span>
                        </h2>
                        <a href="{{ route('products.index', ['search' => $query]) }}" class="text-xs font-semibold text-blue-600 hover:underline dark:text-blue-400">Lihat di Daftar Produk →</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                            <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-4 py-3">SKU</th>
                                    <th class="px-4 py-3">Nama Produk</th>
                                    <th class="px-4 py-3">Kategori</th>
                                    <th class="px-4 py-3 text-center">Stok</th>
                                    <th class="px-4 py-3 text-right">Harga Beli (AVG)</th>
                                    <th class="px-4 py-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($products as $product)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <td class="px-4 py-3 font-mono text-xs font-semibold text-gray-900 dark:text-white">
                                            {{ $product->sku }}
                                        </td>
                                        <td class="px-4 py-3 font-semibold text-gray-900 dark:text-white">
                                            <a href="{{ route('products.show', $product->id) }}" class="hover:underline hover:text-blue-600 dark:hover:text-blue-400">
                                                {{ $product->name }}
                                            </a>
                                        </td>
                                        <td class="px-4 py-3 text-xs">
                                            {{ $product->category->name ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            @if($product->current_stock <= $product->min_stock)
                                                <span class="rounded bg-red-100 px-2 py-0.5 text-xs font-bold text-red-800 dark:bg-red-900 dark:text-red-300">
                                                    {{ $product->current_stock }} {{ $product->unit }}
                                                </span>
                                            @else
                                                <span class="rounded bg-green-100 px-2 py-0.5 text-xs font-bold text-green-800 dark:bg-green-900 dark:text-green-300">
                                                    {{ $product->current_stock }} {{ $product->unit }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-right font-mono text-xs font-bold text-gray-900 dark:text-white">
                                            Rp {{ number_format($product->buy_price, 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-3 text-right">
                                            <a href="{{ route('products.show', $product->id) }}" class="text-xs font-semibold text-blue-600 hover:underline dark:text-blue-400">
                                                Detail →
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- 2. HAK HASIL: TRANSAKSI STOK -->
            @if($transactions->isNotEmpty())
                <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <div class="mb-4 flex items-center justify-between">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            🔄 Transaksi Stok (Masuk / Keluar)
                            <span class="rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-bold text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                {{ $transactions->count() }}
                            </span>
                        </h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                            <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-4 py-3">Kode TRX</th>
                                    <th class="px-4 py-3">Tipe</th>
                                    <th class="px-4 py-3">Produk</th>
                                    <th class="px-4 py-3 text-center">Jumlah</th>
                                    <th class="px-4 py-3">Petugas</th>
                                    <th class="px-4 py-3 text-right">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($transactions as $trx)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <td class="px-4 py-3 font-mono text-xs font-semibold text-gray-900 dark:text-white">
                                            {{ $trx->transaction_code }}
                                        </td>
                                        <td class="px-4 py-3">
                                            @if($trx->type === 'in')
                                                <span class="rounded-md bg-green-100 px-2 py-0.5 text-xs font-bold text-green-800 dark:bg-green-900 dark:text-green-300">MASUK</span>
                                            @else
                                                <span class="rounded-md bg-red-100 px-2 py-0.5 text-xs font-bold text-red-800 dark:bg-red-900 dark:text-red-300">KELUAR</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="font-semibold text-gray-900 dark:text-white">{{ $trx->product->name ?? '-' }}</div>
                                            <div class="text-xs text-gray-400">{{ $trx->product->sku ?? '' }}</div>
                                        </td>
                                        <td class="px-4 py-3 text-center font-bold {{ $trx->type === 'in' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                            {{ $trx->type === 'in' ? '+' : '-' }}{{ $trx->quantity }} {{ $trx->product->unit ?? '' }}
                                        </td>
                                        <td class="px-4 py-3 text-xs">
                                            {{ $trx->user->name ?? 'System' }}
                                        </td>
                                        <td class="px-4 py-3 text-right text-xs font-mono">
                                            {{ $trx->transaction_date->format('d/m/Y') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- 3. HAK HASIL: SUPPLIER -->
            @if($suppliers->isNotEmpty())
                <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <div class="mb-4 flex items-center justify-between">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            🏢 Supplier (Pemasok)
                            <span class="rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-bold text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                {{ $suppliers->count() }}
                            </span>
                        </h2>
                        <a href="{{ route('suppliers.index', ['search' => $query]) }}" class="text-xs font-semibold text-blue-600 hover:underline dark:text-blue-400">Lihat di Daftar Supplier →</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                            <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-4 py-3">Kode</th>
                                    <th class="px-4 py-3">Nama Supplier</th>
                                    <th class="px-4 py-3">Kontak Info</th>
                                    <th class="px-4 py-3">Alamat</th>
                                    <th class="px-4 py-3 text-center">Produk</th>
                                    <th class="px-4 py-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($suppliers as $sup)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <td class="px-4 py-3 font-mono text-xs font-semibold text-gray-900 dark:text-white">
                                            {{ $sup->code }}
                                        </td>
                                        <td class="px-4 py-3 font-semibold text-gray-900 dark:text-white">
                                            <a href="{{ route('suppliers.show', $sup->id) }}" class="hover:underline hover:text-blue-600 dark:hover:text-blue-400">
                                                {{ $sup->name }}
                                            </a>
                                        </td>
                                        <td class="px-4 py-3 text-xs">
                                            <div>Email: {{ $sup->email ?? '-' }}</div>
                                            <div>Telp: {{ $sup->phone ?? '-' }}</div>
                                        </td>
                                        <td class="px-4 py-3 text-xs max-w-xs truncate">
                                            {{ $sup->address ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <span class="rounded bg-blue-50 px-2 py-0.5 text-xs font-bold text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                                {{ $sup->products_count }} Produk
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-right">
                                            <a href="{{ route('suppliers.show', $sup->id) }}" class="text-xs font-semibold text-blue-600 hover:underline dark:text-blue-400">
                                                Detail →
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- 4. HAK HASIL: KATEGORI PRODUK -->
            @if($categories->isNotEmpty())
                <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <div class="mb-4 flex items-center justify-between">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            🏷️ Kategori Produk
                            <span class="rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-bold text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                {{ $categories->count() }}
                            </span>
                        </h2>
                        @role('admin')
                            <a href="{{ route('categories.index') }}" class="text-xs font-semibold text-blue-600 hover:underline dark:text-blue-400">Kelola Kategori →</a>
                        @endrole
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                            <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-4 py-3">Nama Kategori</th>
                                    <th class="px-4 py-3">Deskripsi</th>
                                    <th class="px-4 py-3 text-center">Jumlah Produk</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($categories as $cat)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <td class="px-4 py-3 font-semibold text-gray-900 dark:text-white">
                                            {{ $cat->name }}
                                        </td>
                                        <td class="px-4 py-3 text-xs">
                                            {{ $cat->description ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <span class="rounded bg-blue-50 px-2.5 py-0.5 text-xs font-bold text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                                {{ $cat->products_count }} Produk
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    @endif
</div>
@endsection
