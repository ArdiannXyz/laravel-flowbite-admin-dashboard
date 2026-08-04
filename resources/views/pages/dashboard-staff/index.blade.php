@extends('layouts.dashboard')

@section('content')
<div class="p-4">

    {{-- ============ HEADER ============ --}}
    <div class="mb-4">
        <h1 class="text-xl font-semibold text-gray-900 dark:text-white">Dashboard Staff Gudang</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">Daftar tugas yang harus diselesaikan hari ini</p>
    </div>

    {{-- ============ RINGKASAN TUGAS ============ --}}
    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div class="flex items-center gap-4 rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900">
                <svg class="h-6 w-6 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Barang Masuk Perlu Diperiksa</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">2 tugas</p>
            </div>
        </div>
        <div class="flex items-center gap-4 rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-purple-100 dark:bg-purple-900">
                <svg class="h-6 w-6 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Barang Keluar Perlu Disiapkan</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">2 tugas</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

        {{-- ================================================================ --}}
        {{-- BARANG MASUK YANG PERLU DIPERIKSA --}}
        {{-- ================================================================ --}}
        <div class="rounded-lg border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800">
            <div class="flex items-center justify-between border-b border-gray-200 p-4 dark:border-gray-700">
                <h2 class="text-base font-semibold text-gray-900 dark:text-white">Barang Masuk yang Perlu Diperiksa</h2>
                <span class="rounded bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-300">Pending</span>
            </div>

            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                {{-- Item dummy, nanti diganti @forelse($barangMasuk as $item) --}}
                <li class="flex items-center justify-between gap-4 p-4">
                    <div class="min-w-0">
                        <p class="truncate font-medium text-gray-900 dark:text-white">Minyak Goreng 2L</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">SKU: MKN-002 &middot; 40 unit &middot; dari CV Sumber Makmur</p>
                        <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">Dicatat 03 Agu 2026, 14:22</p>
                    </div>
                    <button type="button" class="shrink-0 rounded-lg bg-primary-700 px-3 py-2 text-xs font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                        Periksa
                    </button>
                </li>
                <li class="flex items-center justify-between gap-4 p-4">
                    <div class="min-w-0">
                        <p class="truncate font-medium text-gray-900 dark:text-white">Kabel HDMI 2m</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">SKU: ELK-001 &middot; 25 unit &middot; dari PT Elektronik Jaya</p>
                        <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">Dicatat 02 Agu 2026, 09:10</p>
                    </div>
                    <button type="button" class="shrink-0 rounded-lg bg-primary-700 px-3 py-2 text-xs font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                        Periksa
                    </button>
                </li>
            </ul>

            {{-- Kondisi kosong (dipakai kalau nanti list-nya kosong) --}}
            {{--
            <div class="p-8 text-center">
                <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada barang masuk yang perlu diperiksa saat ini.</p>
            </div>
            --}}
        </div>

        {{-- ================================================================ --}}
        {{-- BARANG KELUAR YANG PERLU DISIAPKAN --}}
        {{-- ================================================================ --}}
        <div class="rounded-lg border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800">
            <div class="flex items-center justify-between border-b border-gray-200 p-4 dark:border-gray-700">
                <h2 class="text-base font-semibold text-gray-900 dark:text-white">Barang Keluar yang Perlu Disiapkan</h2>
                <span class="rounded bg-purple-100 px-2 py-0.5 text-xs font-medium text-purple-800 dark:bg-purple-900 dark:text-purple-300">Pending</span>
            </div>

            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                {{-- Item dummy, nanti diganti @forelse($barangKeluar as $item) --}}
                <li class="flex items-center justify-between gap-4 p-4">
                    <div class="min-w-0">
                        <p class="truncate font-medium text-gray-900 dark:text-white">Power Bank 10000mAh</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">SKU: ELK-002 &middot; 3 unit</p>
                        <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">Diminta 03 Agu 2026, 11:00</p>
                    </div>
                    <button type="button" class="shrink-0 rounded-lg bg-primary-700 px-3 py-2 text-xs font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                        Siapkan
                    </button>
                </li>
                <li class="flex items-center justify-between gap-4 p-4">
                    <div class="min-w-0">
                        <p class="truncate font-medium text-gray-900 dark:text-white">Kaos Polos Cotton Combed</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">SKU: PKN-001 &middot; 6 unit</p>
                        <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">Diminta 02 Agu 2026, 16:30</p>
                    </div>
                    <button type="button" class="shrink-0 rounded-lg bg-primary-700 px-3 py-2 text-xs font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                        Siapkan
                    </button>
                </li>
            </ul>
        </div>

    </div>
</div>
@endsection