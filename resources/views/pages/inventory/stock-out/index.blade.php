@extends('layouts.dashboard')

@section('content')
<div class="px-4 pt-6">
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Riwayat Barang Keluar</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Pencatatan pengeluaran barang untuk penjualan, pengiriman, atau retur.</p>
        </div>
        <div>
            <a href="{{ route('stock-out.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 dark:focus:ring-red-800">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                Input Pengeluaran Barang
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-lg bg-green-50 p-4 text-sm text-green-800 dark:bg-gray-800 dark:text-green-400" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filter Form -->
    <div class="mb-4 rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <form method="GET" action="{{ route('stock-out.index') }}" class="flex flex-col gap-4 md:flex-row md:items-center">
            <div class="flex-1">
                <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Cari Kode TRX atau Nama Produk..." class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-red-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
            </div>
            <div class="flex items-center gap-2">
                <input type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}" class="rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-red-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                <span class="text-gray-500 dark:text-gray-400">s/d</span>
                <input type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}" class="rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-red-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
            </div>
            <div class="flex items-center gap-2">
                <button type="submit" class="rounded-lg bg-gray-800 px-4 py-2.5 text-sm font-medium text-white hover:bg-gray-900 dark:bg-gray-700 dark:hover:bg-gray-600">Filter</button>
                <a href="{{ route('stock-out.index') }}" class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">Reset</a>
            </div>
        </form>
    </div>

    <!-- Transactions Table -->
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3">Kode Transaksi</th>
                        <th class="px-6 py-3">Nama Produk</th>
                        <th class="px-6 py-3 text-center">Jumlah Keluar</th>
                        <th class="px-6 py-3">Harga Satuan</th>
                        <th class="px-6 py-3">Catatan / Tujuan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($transactions as $trx)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4 text-xs font-medium text-gray-900 dark:text-white">
                                {{ $trx->transaction_date->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 font-mono text-xs font-semibold text-red-700 dark:text-red-400">
                                {{ $trx->transaction_code }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ $trx->product->name ?? '-' }}
                                <div class="text-xs font-normal text-gray-400">SKU: {{ $trx->product->sku ?? '' }}</div>
                            </td>
                            <td class="px-6 py-4 text-center font-extrabold text-red-600 dark:text-red-400">
                                -{{ $trx->quantity }} {{ $trx->product->unit ?? '' }}
                            </td>
                            <td class="px-6 py-4 text-gray-900 dark:text-white">
                                Rp {{ number_format($trx->unit_price ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-500 dark:text-gray-400">
                                {{ $trx->notes ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-gray-500 dark:text-gray-400">Belum ada transaksi barang keluar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-gray-200 p-4 dark:border-gray-700">
            {{ $transactions->links() }}
        </div>
    </div>
</div>
@endsection
