@extends('layouts.dashboard')

@section('content')
<div class="px-4 pt-6">
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Riwayat Stock Opname</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Hasil audit dan penyesuaian antara stok di sistem dengan perhitungan fisik di gudang.</p>
        </div>
        <div>
            <a href="{{ route('stock-opname.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Pemeriksaan Opname Baru
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
        <form method="GET" action="{{ route('stock-opname.index') }}" class="flex flex-col gap-4 md:flex-row md:items-center">
            <div class="flex-1">
                <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Cari Kode Opname atau Nama Produk..." class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
            </div>
            <div class="flex items-center gap-2">
                <button type="submit" class="rounded-lg bg-gray-800 px-4 py-2.5 text-sm font-medium text-white hover:bg-gray-900 dark:bg-gray-700 dark:hover:bg-gray-600">Filter</button>
                <a href="{{ route('stock-opname.index') }}" class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">Refresh</a>
            </div>
        </form>
    </div>

    <!-- Opname Table -->
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3">Kode Opname</th>
                        <th class="px-6 py-3">Produk</th>
                        <th class="px-6 py-3 text-center">Stok Sistem</th>
                        <th class="px-6 py-3 text-center">Stok Fisik</th>
                        <th class="px-6 py-3 text-center">Selisih</th>
                        <th class="px-6 py-3">Catatan Audit</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($opnames as $opn)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4 text-xs font-medium text-gray-900 dark:text-white">
                                {{ $opn->opname_date->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 font-mono text-xs font-semibold text-blue-700 dark:text-blue-400">
                                {{ $opn->opname_code }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ $opn->product->name ?? '-' }}
                                <div class="text-xs font-normal text-gray-400">SKU: {{ $opn->product->sku ?? '' }}</div>
                            </td>
                            <td class="px-6 py-4 text-center font-medium text-gray-700 dark:text-gray-300">
                                {{ $opn->system_stock }} {{ $opn->product->unit ?? '' }}
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-gray-900 dark:text-white">
                                {{ $opn->physical_stock }} {{ $opn->product->unit ?? '' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($opn->difference > 0)
                                    <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-bold text-green-800 dark:bg-green-900 dark:text-green-300">
                                        +{{ $opn->difference }} (Lebih)
                                    </span>
                                @elseif($opn->difference < 0)
                                    <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-bold text-red-800 dark:bg-red-900 dark:text-red-300">
                                        {{ $opn->difference }} (Kurang)
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-bold text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                        0 (Sesuai)
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-500 dark:text-gray-400">
                                {{ $opn->notes ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-gray-500 dark:text-gray-400">Belum ada riwayat stock opname.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-gray-200 p-4 dark:border-gray-700">
            {{ $opnames->links() }}
        </div>
    </div>
</div>
@endsection
