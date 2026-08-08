@extends('layouts.dashboard')

@section('content')
<div class="px-4 pt-6">
    <!-- Header Title -->
    <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div class="min-w-0 flex-1">
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Dashboard Manajer Gudang</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Monitoring ketersediaan stok, transaksi barang masuk/keluar, dan rekomendasi restock real-time.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('stock-in.create') }}" class="inline-flex items-center gap-2 whitespace-nowrap rounded-lg bg-green-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-300 dark:focus:ring-green-800 transition-all shadow-sm">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Barang Masuk
            </a>
            <a href="{{ route('stock-out.create') }}" class="inline-flex items-center gap-2 whitespace-nowrap rounded-lg bg-red-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 dark:focus:ring-red-800 transition-all shadow-sm">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                Barang Keluar
            </a>
            <a href="{{ route('stock-opname.create') }}" class="inline-flex items-center gap-2 whitespace-nowrap rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800 transition-all shadow-sm">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Stock Opname
            </a>
        </div>
    </div>

    <!-- Alert Flash Messages -->
    @if(session('success'))
        <div class="mb-4 flex items-center rounded-lg bg-green-50 p-4 text-sm text-green-800 dark:bg-gray-800 dark:text-green-400" role="alert">
            <svg class="mr-3 inline h-4 w-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/></svg>
            <div>{{ session('success') }}</div>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 flex items-center rounded-lg bg-red-50 p-4 text-sm text-red-800 dark:bg-gray-800 dark:text-red-400" role="alert">
            <svg class="mr-3 inline h-4 w-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.707a1 1 0 0 1-1.414 0L10 10.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 9 6.293 6.707a1 1 0 0 1 1.414-1.414L10 7.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 9l2.293 2.293a1 1 0 0 1 0 1.414Z"/></svg>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    <!-- KPI Summary Grid -->
    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Total Produk -->
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">Total Produk</p>
                    <h3 class="mt-1 text-3xl font-extrabold text-gray-900 dark:text-white">{{ $summary['total_products'] }}</h3>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">SKU terdaftar di gudang</p>
                </div>
                <div class="rounded-lg bg-blue-50 p-2.5 text-blue-600 dark:bg-blue-900 dark:text-blue-300">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
            </div>
        </div>

        <!-- Stok Menipis (Warning) -->
        <div class="rounded-xl border border-amber-200 bg-amber-50/50 p-5 shadow-sm dark:border-amber-900/50 dark:bg-gray-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase text-amber-700 dark:text-amber-400">Stok Menipis (Alert)</p>
                    <h3 class="mt-1 text-3xl font-extrabold text-amber-900 dark:text-amber-400">{{ $summary['low_stock_count'] }}</h3>
                    <p class="mt-1 text-xs text-amber-600 dark:text-amber-400">Perlu restock segera</p>
                </div>
                <div class="rounded-lg bg-amber-100 p-2.5 text-amber-600 dark:bg-amber-900 dark:text-amber-300">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
            </div>
        </div>

        <!-- Barang Masuk Hari Ini -->
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">Barang Masuk (Hari Ini)</p>
                    <h3 class="mt-1 text-3xl font-extrabold text-green-600 dark:text-green-400">+{{ $summary['today_stock_in_qty'] }}</h3>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $summary['today_stock_in_count'] }} transaksi penerimaan</p>
                </div>
                <div class="rounded-lg bg-green-50 p-2.5 text-green-600 dark:bg-green-900 dark:text-green-300">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                </div>
            </div>
        </div>

        <!-- Barang Keluar Hari Ini -->
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">Barang Keluar (Hari Ini)</p>
                    <h3 class="mt-1 text-3xl font-extrabold text-red-600 dark:text-red-400">-{{ $summary['today_stock_out_qty'] }}</h3>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $summary['today_stock_out_count'] }} transaksi pengeluaran</p>
                </div>
                <div class="rounded-lg bg-red-50 p-2.5 text-red-600 dark:bg-red-900 dark:text-red-300">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Grid: Low Stock Alert & Recent Activity -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- Low Stock Warning Box (Left Column) -->
        <div x-data="{ page: 1, pageSize: 3, total: {{ $summary['low_stock_products']->count() }} }" class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800 flex flex-col justify-between">
            <div>
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <span class="inline-block h-3 w-3 rounded-full bg-amber-500 animate-pulse"></span>
                        Perlu Restock Segera
                    </h2>
                    <a href="{{ route('products.index', ['low_stock' => 1]) }}" class="text-xs font-semibold text-blue-600 hover:underline dark:text-blue-400">Lihat Semua</a>
                </div>

                @if($summary['low_stock_products']->isEmpty())
                    <div class="py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                        <svg class="mx-auto h-10 w-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="mt-2 font-medium">Stok barang di gudang aman.</p>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($summary['low_stock_products'] as $index => $product)
                            <div x-show="{{ $index }} >= (page - 1) * pageSize && {{ $index }} < page * pageSize" class="flex items-center justify-between rounded-lg border border-amber-100 bg-amber-50/60 p-3 dark:border-amber-900/30 dark:bg-gray-700/50">
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white">{{ $product->name }}</h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">SKU: {{ $product->sku }} | Min: {{ $product->min_stock }} {{ $product->unit }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center rounded-full bg-amber-100 px-2.5 py-1 text-xs font-bold text-amber-800 dark:bg-amber-900 dark:text-amber-300">
                                        {{ $product->current_stock }} {{ $product->unit }}
                                    </span>
                                    <div class="mt-1">
                                        <a href="{{ route('stock-in.create', ['product_id' => $product->id]) }}" class="text-xs font-semibold text-green-600 hover:underline dark:text-green-400">+ Restock</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            @if($summary['low_stock_products']->count() > 3)
                <div class="mt-4 pt-3 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                    <span>Hal <strong x-text="page" class="text-gray-800 dark:text-gray-200"></strong> dari <strong x-text="Math.ceil(total / pageSize)" class="text-gray-800 dark:text-gray-200"></strong></span>
                    <div class="flex items-center gap-1">
                        <button type="button" @click="if (page > 1) page--" :disabled="page === 1" :class="page === 1 ? 'opacity-40 cursor-not-allowed' : 'hover:bg-gray-100 dark:hover:bg-gray-700'" class="rounded border border-gray-300 dark:border-gray-600 px-2.5 py-1 font-medium">
                            ← Prev
                        </button>
                        <button type="button" @click="if (page * pageSize < total) page++" :disabled="page * pageSize >= total" :class="page * pageSize >= total ? 'opacity-40 cursor-not-allowed' : 'hover:bg-gray-100 dark:hover:bg-gray-700'" class="rounded border border-gray-300 dark:border-gray-600 px-2.5 py-1 font-medium">
                            Next →
                        </button>
                    </div>
                </div>
            @endif
        </div>

        <!-- Recent Transactions Table (Right Columns) -->
        <div x-data="{ page: 1, pageSize: 3, total: {{ $summary['recent_transactions']->count() }} }" class="lg:col-span-2 rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800 flex flex-col justify-between">
            <div>
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">Riwayat Transaksi Stok Terbaru</h2>
                    <div class="flex gap-2">
                        <a href="{{ route('stock-in.index') }}" class="text-xs font-semibold text-green-600 hover:underline dark:text-green-400">Barang Masuk →</a>
                        <a href="{{ route('stock-out.index') }}" class="text-xs font-semibold text-red-600 hover:underline dark:text-red-400">Barang Keluar →</a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th class="px-4 py-3">Kode TRX</th>
                                <th class="px-4 py-3">Jenis</th>
                                <th class="px-4 py-3">Produk</th>
                                <th class="px-4 py-3 text-center">Jumlah</th>
                                <th class="px-4 py-3">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($summary['recent_transactions'] as $index => $trx)
                                <tr x-show="{{ $index }} >= (page - 1) * pageSize && {{ $index }} < page * pageSize" class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <td class="px-4 py-3 text-xs font-medium text-gray-800 dark:text-gray-200">
                                        {{ $trx->transaction_code }}
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($trx->type === 'in')
                                            <span class="rounded-md bg-green-100 px-2 py-1 text-xs font-bold text-green-800 dark:bg-green-900 dark:text-green-300">MASUK</span>
                                        @else
                                            <span class="rounded-md bg-red-100 px-2 py-1 text-xs font-bold text-red-800 dark:bg-red-900 dark:text-red-300">KELUAR</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="font-semibold text-gray-900 dark:text-white">{{ $trx->product->name ?? '-' }}</div>
                                        <div class="text-xs text-gray-400">{{ $trx->product->sku ?? '' }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-center font-bold text-sm {{ $trx->type === 'in' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                        {{ $trx->type === 'in' ? '+' : '-' }}{{ $trx->quantity }} {{ $trx->product->unit ?? '' }}
                                    </td>
                                    <td class="px-4 py-3 text-xs text-gray-500 dark:text-gray-400">
                                        {{ $trx->transaction_date->format('d/m/Y') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-6 text-center text-gray-500 dark:text-gray-400">Belum ada data transaksi stok.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($summary['recent_transactions']->count() > 3)
                <div class="mt-4 pt-3 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                    <span>Menampilkan <span x-text="Math.min((page - 1) * pageSize + 1, total)"></span> - <span x-text="Math.min(page * pageSize, total)"></span> dari <strong x-text="total" class="text-gray-800 dark:text-gray-200"></strong> data</span>
                    <div class="flex items-center gap-1">
                        <button type="button" @click="if (page > 1) page--" :disabled="page === 1" :class="page === 1 ? 'opacity-40 cursor-not-allowed' : 'hover:bg-gray-100 dark:hover:bg-gray-700'" class="rounded border border-gray-300 dark:border-gray-600 px-3 py-1 font-medium">
                            ← Prev
                        </button>
                        <span class="px-2 font-medium">Hal <strong x-text="page"></strong>/<strong x-text="Math.ceil(total / pageSize)"></strong></span>
                        <button type="button" @click="if (page * pageSize < total) page++" :disabled="page * pageSize >= total" :class="page * pageSize >= total ? 'opacity-40 cursor-not-allowed' : 'hover:bg-gray-100 dark:hover:bg-gray-700'" class="rounded border border-gray-300 dark:border-gray-600 px-3 py-1 font-medium">
                            Next →
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
