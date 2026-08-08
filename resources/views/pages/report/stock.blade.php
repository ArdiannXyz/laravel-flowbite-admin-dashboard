@extends('layouts.dashboard')

@section('content')
<div class="p-4">

    {{-- HEADER --}}
    <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Laporan Stok Barang</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Ringkasan ketersediaan stok fisik produk, sisa kuantitas, dan estimasi nilai persediaan.</p>
        </div>
    </div>

    {{-- KARTU RINGKASAN STOK --}}
    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
        <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Produk Terdaftar</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($totalProducts ?? 0) }}</p>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Nilai Persediaan</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($totalStockValue ?? 0, 0, ',', '.') }}</p>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <p class="text-sm text-gray-500 dark:text-gray-400">Stok Kritis / Menipis</p>
            <p class="text-2xl font-bold text-red-600 dark:text-red-400">{{ number_format($lowStockCount ?? 0) }} Item</p>
        </div>
    </div>

    {{-- FILTER & EXPORT --}}
    <div class="mb-6 rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <form method="GET" action="{{ route('report.stock') }}" class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                <div>
                    <label class="mb-1 block text-xs font-medium text-gray-700 dark:text-gray-300">Filter Kategori</label>
                    <select name="category_id" onchange="this.form.submit()" class="block w-full min-w-[200px] rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-1 block text-xs font-medium text-gray-700 dark:text-gray-300">Status Stok</label>
                    <select name="stock_status" onchange="this.form.submit()" class="block w-full min-w-[160px] rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <option value="">Semua Status</option>
                        <option value="aman" {{ request('stock_status') == 'aman' ? 'selected' : '' }}>Aman</option>
                        <option value="menipis" {{ request('stock_status') == 'menipis' ? 'selected' : '' }}>Menipis</option>
                    </select>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('report.export.stok', request()->only(['category_id', 'stock_status'])) }}" class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition-all hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Export PDF
                </a>
                <a href="{{ route('report.export.stok-excel', request()->only(['category_id', 'stock_status'])) }}" class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition-all hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-300">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Export Excel
                </a>
            </div>
        </form>
    </div>

    {{-- TABEL LAPORAN STOK --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-3">SKU</th>
                        <th class="px-6 py-3">Nama Produk</th>
                        <th class="px-6 py-3">Kategori</th>
                        <th class="px-6 py-3 text-right">Stok Saat Ini</th>
                        <th class="px-6 py-3 text-right">Stok Minimum</th>
                        <th class="px-6 py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($stokProducts as $item)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4 font-mono font-medium text-gray-900 dark:text-white whitespace-nowrap">{{ $item->sku }}</td>
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">{{ $item->name }}</td>
                            <td class="px-6 py-4">{{ $item->category->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-right font-bold text-gray-900 dark:text-white">{{ number_format($item->current_stock) }} {{ $item->unit }}</td>
                            <td class="px-6 py-4 text-right text-gray-500 dark:text-gray-400">{{ number_format($item->min_stock) }} {{ $item->unit }}</td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                @if($item->current_stock < $item->min_stock)
                                    <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-bold text-red-800 dark:bg-red-900/40 dark:text-red-300">Stok Menipis</span>
                                @else
                                    <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-bold text-green-800 dark:bg-green-900/40 dark:text-green-300">Aman</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-gray-500 dark:text-gray-400">Tidak ada data stok produk ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-gray-200 p-4 dark:border-gray-700">
            {{ $stokProducts->links() }}
        </div>
    </div>
</div>
@endsection
