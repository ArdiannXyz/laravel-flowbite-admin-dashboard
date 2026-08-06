@extends('layouts.dashboard')

@section('content')
<div class="p-4">

    {{-- HEADER --}}
    <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Laporan Barang Masuk & Keluar</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Rekap riwayat mutasi stok penerimaan dan pengeluaran barang gudang per periode.</p>
        </div>
    </div>

    {{-- FILTER & EXPORT BARANG MASUK --}}
    <div class="mb-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between border-b pb-4 dark:border-gray-700">
            <div>
                <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <span class="h-3 w-3 rounded-full bg-green-500"></span>
                    1. Riwayat Barang Masuk (Penerimaan Gudang)
                </h2>
            </div>
            <div class="flex items-center gap-3 mt-3 sm:mt-0">
                <a href="{{ route('report.export.masuk', request()->only(['masuk_from_date', 'masuk_to_date'])) }}" class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition-all hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Export PDF
                </a>
                <a href="{{ route('report.export.masuk-excel', request()->only(['masuk_from_date', 'masuk_to_date'])) }}" class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition-all hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-300">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Export Excel
                </a>
            </div>
        </div>

        <form method="GET" action="{{ route('report.transaction') }}" class="mb-4 flex flex-col gap-4 sm:flex-row sm:items-center">
            <div>
                <label class="mb-1 block text-xs font-medium text-gray-700 dark:text-gray-300">Dari Tanggal</label>
                <input type="date" name="masuk_from_date" value="{{ request('masuk_from_date') }}" onchange="this.form.submit()" class="rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
            </div>
            <div>
                <label class="mb-1 block text-xs font-medium text-gray-700 dark:text-gray-300">Sampai Tanggal</label>
                <input type="date" name="masuk_to_date" value="{{ request('masuk_to_date') }}" onchange="this.form.submit()" class="rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
            </div>
            @if(request('masuk_from_date') || request('masuk_to_date'))
                <div class="sm:self-end">
                    <a href="{{ route('report.transaction') }}" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">Reset Filter</a>
                </div>
            @endif
        </form>

        <div class="overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700">
            <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">SKU</th>
                        <th class="px-4 py-3">Nama Produk</th>
                        <th class="px-4 py-3 text-right">Jumlah (Qty)</th>
                        <th class="px-4 py-3">Supplier</th>
                        <th class="px-4 py-3">Petugas Pencatat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($barangMasuk as $item)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-4 py-3 font-medium text-gray-900 dark:text-white whitespace-nowrap">{{ \Carbon\Carbon::parse($item->transaction_date)->translatedFormat('d M Y') }}</td>
                            <td class="px-4 py-3 font-mono text-xs">{{ $item->product->sku ?? '-' }}</td>
                            <td class="px-4 py-3 font-semibold text-gray-900 dark:text-white">{{ $item->product->name ?? 'N/A' }}</td>
                            <td class="px-4 py-3 text-right font-bold text-green-600 dark:text-green-400">+{{ number_format($item->quantity) }}</td>
                            <td class="px-4 py-3">{{ $item->supplier->name ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $item->user->name ?? 'System' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-gray-500 dark:text-gray-400">Tidak ada data riwayat barang masuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $barangMasuk->links() }}
        </div>
    </div>

    {{-- FILTER & EXPORT BARANG KELUAR --}}
    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between border-b pb-4 dark:border-gray-700">
            <div>
                <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <span class="h-3 w-3 rounded-full bg-red-500"></span>
                    2. Riwayat Barang Keluar (Pengeluaran Gudang)
                </h2>
            </div>
            <div class="flex items-center gap-3 mt-3 sm:mt-0">
                <a href="{{ route('report.export.keluar', request()->only(['keluar_from_date', 'keluar_to_date'])) }}" class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition-all hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Export PDF
                </a>
                <a href="{{ route('report.export.keluar-excel', request()->only(['keluar_from_date', 'keluar_to_date'])) }}" class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition-all hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-300">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Export Excel
                </a>
            </div>
        </div>

        <form method="GET" action="{{ route('report.transaction') }}" class="mb-4 flex flex-col gap-4 sm:flex-row sm:items-center">
            <div>
                <label class="mb-1 block text-xs font-medium text-gray-700 dark:text-gray-300">Dari Tanggal</label>
                <input type="date" name="keluar_from_date" value="{{ request('keluar_from_date') }}" onchange="this.form.submit()" class="rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
            </div>
            <div>
                <label class="mb-1 block text-xs font-medium text-gray-700 dark:text-gray-300">Sampai Tanggal</label>
                <input type="date" name="keluar_to_date" value="{{ request('keluar_to_date') }}" onchange="this.form.submit()" class="rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
            </div>
            @if(request('keluar_from_date') || request('keluar_to_date'))
                <div class="sm:self-end">
                    <a href="{{ route('report.transaction') }}" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">Reset Filter</a>
                </div>
            @endif
        </form>

        <div class="overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700">
            <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">SKU</th>
                        <th class="px-4 py-3">Nama Produk</th>
                        <th class="px-4 py-3 text-right">Jumlah (Qty)</th>
                        <th class="px-4 py-3">Petugas Pencatat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($barangKeluar as $item)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-4 py-3 font-medium text-gray-900 dark:text-white whitespace-nowrap">{{ \Carbon\Carbon::parse($item->transaction_date)->translatedFormat('d M Y') }}</td>
                            <td class="px-4 py-3 font-mono text-xs">{{ $item->product->sku ?? '-' }}</td>
                            <td class="px-4 py-3 font-semibold text-gray-900 dark:text-white">{{ $item->product->name ?? 'N/A' }}</td>
                            <td class="px-4 py-3 text-right font-bold text-red-600 dark:text-red-400">-{{ number_format($item->quantity) }}</td>
                            <td class="px-4 py-3">{{ $item->user->name ?? 'System' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-gray-500 dark:text-gray-400">Tidak ada data riwayat barang keluar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $barangKeluar->links() }}
        </div>
    </div>

</div>
@endsection
