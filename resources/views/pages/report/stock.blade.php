@extends('layouts.dashboard')

@section('content')
<div class="px-4 pt-6">
    <!-- Header & Tombol Export -->
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Laporan Stok Barang</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Rekapitulasi total persediaan dan status stok produk gudang saat ini.</p>
        </div>
        <div class="flex items-center gap-2">
            <!-- Tombol Export PDF & Excel -->
            <div class="inline-flex rounded-md shadow-sm">
                <a href="{{ route('report.export.stok', request()->all()) }}" class="inline-flex items-center gap-1 rounded-l-lg border border-gray-300 bg-white px-3 py-2 text-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">
                    📄 Export PDF
                </a>
                <a href="{{ route('report.export.stok-excel', request()->all()) }}" class="inline-flex items-center gap-1 rounded-r-lg border-t border-b border-r border-gray-300 bg-white px-3 py-2 text-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">
                    📊 Export Excel
                </a>
            </div>
        </div>
    </div>

    <!-- Filter / Search Form -->
    <div class="mb-6 rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <form method="GET" action="{{ route('report.stock') }}" class="flex flex-col gap-4 md:flex-row md:items-center">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Berdasarkan Nama Produk atau SKU..." class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
            </div>
            <div class="flex items-center gap-2">
                <button type="submit" class="rounded-lg bg-gray-800 px-4 py-2.5 text-sm font-medium text-white hover:bg-gray-900 dark:bg-gray-700">Cari</button>
                <a href="{{ route('report.stock') }}" class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">Reset</a>
            </div>
        </form>
    </div>

    <!-- Tabel Data Stok -->
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <div class="border-b border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-700/50 flex justify-between items-center">
            <h2 class="text-base font-semibold text-gray-900 dark:text-white">Daftar Inventaris Produk</h2>
            <span class="rounded bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-300">Total: {{ count($stok) }} Produk</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-3">SKU</th>
                        <th class="px-6 py-3">Nama Produk</th>
                        <th class="px-6 py-3">Kategori</th>
                        <th class="px-6 py-3 text-center">Stok Saat Ini</th>
                        <th class="px-6 py-3 text-center">Status Stok</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($stok as $item)
                        @php
                            $minStock = $item->min_stock ?? 5;
                            $isLowStock = $item->current_stock <= $minStock;
                        @endphp
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4 font-mono text-xs font-semibold text-gray-700 dark:text-gray-300">
                                {{ $item->sku }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ $item->name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $item->category->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-gray-900 dark:text-white">
                                {{ $item->current_stock }} <span class="text-xs font-normal text-gray-500">{{ $item->unit }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($item->current_stock <= 0)
                                    <span class="rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800 dark:bg-red-900 dark:text-red-300">Habis</span>
                                @elseif($isLowStock)
                                    <span class="rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">Menipis</span>
                                @else
                                    <span class="rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-300">Aman</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-500 dark:text-gray-400">Tidak ada data stok produk yang ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection