@extends('layouts.dashboard')

@section('content')
<div class="px-4 pt-6">
    <!-- Header & Tombol Export -->
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Laporan Transaksi Masuk & Keluar</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Rekapitulasi mutasi stok barang gudang secara keseluruhan.</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <!-- Export Barang Masuk -->
            <div class="inline-flex rounded-md shadow-sm">
                <a href="{{ route('report.export.masuk', request()->all()) }}" class="inline-flex items-center gap-1 rounded-l-lg border border-gray-300 bg-white px-3 py-2 text-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">
                    📄 PDF Masuk
                </a>
                <a href="{{ route('report.export.masuk-excel', request()->all()) }}" class="inline-flex items-center gap-1 rounded-r-lg border-t border-b border-r border-gray-300 bg-white px-3 py-2 text-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">
                    📊 Excel Masuk
                </a>
            </div>
            <!-- Export Barang Keluar -->
            <div class="inline-flex rounded-md shadow-sm">
                <a href="{{ route('report.export.keluar', request()->all()) }}" class="inline-flex items-center gap-1 rounded-l-lg border border-gray-300 bg-white px-3 py-2 text-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">
                    📄 PDF Keluar
                </a>
                <a href="{{ route('report.export.keluar-excel', request()->all()) }}" class="inline-flex items-center gap-1 rounded-r-lg border-t border-b border-r border-gray-300 bg-white px-3 py-2 text-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">
                    📊 Excel Keluar
                </a>
            </div>
        </div>
    </div>

    <!-- Filter Form berdasarkan Tanggal -->
    <div class="mb-6 rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <form method="GET" action="{{ route('report.transaction') }}" class="flex flex-col gap-4 md:flex-row md:items-center">
            <div class="flex items-center gap-2 flex-1">
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                <span class="text-gray-500 dark:text-gray-400">s/d</span>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
            </div>
            <div class="flex items-center gap-2">
                <button type="submit" class="rounded-lg bg-gray-800 px-4 py-2.5 text-sm font-medium text-white hover:bg-gray-900 dark:bg-gray-700">Filter</button>
                <a href="{{ route('report.transaction') }}" class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">Reset</a>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 gap-8">
        <!-- TABEL 1: BARANG MASUK -->
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="border-b border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-700/50 flex justify-between items-center">
                <h2 class="text-base font-semibold text-gray-900 dark:text-white">Riwayat Barang Masuk</h2>
                <span class="rounded bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-300">Total: {{ count($barangMasuk) }} Data</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-3">Tanggal</th>
                            <th class="px-6 py-3">Kode TRX</th>
                            <th class="px-6 py-3">Produk</th>
                            <th class="px-6 py-3 text-center">Jumlah Masuk</th>
                            <th class="px-6 py-3">Harga Satuan</th>
                            <th class="px-6 py-3 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($barangMasuk as $trx)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="px-6 py-4 text-xs font-medium text-gray-900 dark:text-white">
                                    {{ \Carbon\Carbon::parse($trx->transaction_date)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 font-mono text-xs font-semibold text-blue-600 dark:text-blue-400">
                                    {{ $trx->transaction_code }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ $trx->product->name ?? '-' }}
                                    <div class="text-xs font-normal text-gray-400">SKU: {{ $trx->product->sku ?? '' }}</div>
                                </td>
                                <td class="px-6 py-4 text-center font-bold text-green-600 dark:text-green-400">
                                    +{{ $trx->quantity }} {{ $trx->product->unit ?? '' }}
                                </td>
                                <td class="px-6 py-4 text-gray-900 dark:text-white">
                                    Rp {{ number_format($trx->unit_price ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="rounded-full px-2.5 py-0.5 text-xs font-medium {{ $trx->status === 'confirmed' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' }}">
                                        {{ ucfirst($trx->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-gray-500 dark:text-gray-400">Tidak ada data transaksi barang masuk pada rentang tanggal ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- TABEL 2: BARANG KELUAR -->
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="border-b border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-700/50 flex justify-between items-center">
                <h2 class="text-base font-semibold text-gray-900 dark:text-white">Riwayat Barang Keluar</h2>
                <span class="rounded bg-purple-100 px-2.5 py-0.5 text-xs font-medium text-purple-800 dark:bg-purple-900 dark:text-purple-300">Total: {{ count($barangKeluar) }} Data</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-3">Tanggal</th>
                            <th class="px-6 py-3">Kode TRX</th>
                            <th class="px-6 py-3">Produk</th>
                            <th class="px-6 py-3 text-center">Jumlah Keluar</th>
                            <th class="px-6 py-3">Harga Satuan</th>
                            <th class="px-6 py-3 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($barangKeluar as $trx)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="px-6 py-4 text-xs font-medium text-gray-900 dark:text-white">
                                    {{ \Carbon\Carbon::parse($trx->transaction_date)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 font-mono text-xs font-semibold text-red-600 dark:text-red-400">
                                    {{ $trx->transaction_code }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ $trx->product->name ?? '-' }}
                                    <div class="text-xs font-normal text-gray-400">SKU: {{ $trx->product->sku ?? '' }}</div>
                                </td>
                                <td class="px-6 py-4 text-center font-bold text-red-600 dark:text-red-400">
                                    -{{ $trx->quantity }} {{ $trx->product->unit ?? '' }}
                                </td>
                                <td class="px-6 py-4 text-gray-900 dark:text-white">
                                    Rp {{ number_format($trx->unit_price ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="rounded-full px-2.5 py-0.5 text-xs font-medium {{ $trx->status === 'confirmed' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' }}">
                                        {{ ucfirst($trx->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-gray-500 dark:text-gray-400">Tidak ada data transaksi barang keluar pada rentang tanggal ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection