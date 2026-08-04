{{--
  Sesuai struktur project: resources/views/layouts/dashboard.blade.php
  Cek isi dashboard.blade.php: kalau dia pakai @yield('content'), pertahankan @section('content')
  di bawah. Kalau ternyata pakai {{ $slot }} (Blade component, bukan @extends),
  kabari aku dan aku sesuaikan jadi <x-layouts.dashboard> ... </x-layouts.dashboard>.
--}}
@extends('layouts.dashboard')

@section('content')
<div class="p-4">

    {{-- ============ HEADER ============ --}}
    <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-xl font-semibold text-gray-900 dark:text-white">Laporan</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Laporan stok barang, riwayat transaksi, dan aktivitas pengguna</p>
        </div>
    </div>

    {{-- ============ TABS ============ --}}
    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="-mb-px flex flex-wrap text-sm font-medium text-center" id="laporan-tabs" data-tabs-toggle="#laporan-tab-content" role="tablist">
            <li class="mr-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="tab-stok-btn" data-tabs-target="#tab-stok" type="button" role="tab" aria-controls="tab-stok">
                    Laporan Stok
                </button>
            </li>
            <li class="mr-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="tab-masuk-btn" data-tabs-target="#tab-masuk" type="button" role="tab" aria-controls="tab-masuk">
                    Barang Masuk
                </button>
            </li>
            <li class="mr-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="tab-keluar-btn" data-tabs-target="#tab-keluar" type="button" role="tab" aria-controls="tab-keluar">
                    Barang Keluar
                </button>
            </li>
            <li role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="tab-aktivitas-btn" data-tabs-target="#tab-aktivitas" type="button" role="tab" aria-controls="tab-aktivitas">
                    Aktivitas Pengguna
                </button>
            </li>
        </ul>
    </div>

    <div id="laporan-tab-content">

        {{-- ================================================================ --}}
        {{-- TAB 1: LAPORAN STOK --}}
        {{-- ================================================================ --}}
        <div class="hidden rounded-lg" id="tab-stok" role="tabpanel" aria-labelledby="tab-stok-btn">

            {{-- Kartu ringkasan --}}
            <div class="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div class="rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Produk</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">12</p>
                </div>
                <div class="rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Nilai Stok</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">Rp 18.450.000</p>
                </div>
                <div class="rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Stok di Bawah Minimum</p>
                    <p class="text-2xl font-semibold text-red-600 dark:text-red-500">3</p>
                </div>
            </div>

            {{-- Filter & export --}}
            <div class="mb-4 flex flex-col gap-3 rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800 sm:flex-row sm:items-end sm:justify-between">
                <div class="flex flex-col gap-3 sm:flex-row">
                    <div>
                        <label class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">Kategori</label>
                        <select class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            <option>Semua Kategori</option>
                            <option>Elektronik</option>
                            <option>Pakaian</option>
                            <option>Makanan &amp; Minuman</option>
                            <option>Alat Tulis Kantor</option>
                            <option>Perlengkapan Rumah Tangga</option>
                        </select>
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">Status Stok</label>
                        <select class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            <option>Semua</option>
                            <option>Aman</option>
                            <option>Menipis</option>
                        </select>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button type="button" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                        Export PDF
                    </button>
                    <button type="button" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                        Export Excel
                    </button>
                </div>
            </div>

            {{-- Tabel stok --}}
            <div class="relative overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-4 py-3">SKU</th>
                            <th class="px-4 py-3">Nama Produk</th>
                            <th class="px-4 py-3">Kategori</th>
                            <th class="px-4 py-3 text-right">Stok Saat Ini</th>
                            <th class="px-4 py-3 text-right">Stok Minimum</th>
                            <th class="px-4 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Baris dummy, nanti diganti @foreach($stok as $item) --}}
                        <tr class="border-b bg-white dark:border-gray-700 dark:bg-gray-800">
                            <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">ELK-002</td>
                            <td class="px-4 py-3">Power Bank 10000mAh</td>
                            <td class="px-4 py-3">Elektronik</td>
                            <td class="px-4 py-3 text-right">8</td>
                            <td class="px-4 py-3 text-right">10</td>
                            <td class="px-4 py-3">
                                <span class="rounded bg-red-100 px-2 py-0.5 text-xs font-medium text-red-800 dark:bg-red-900 dark:text-red-300">Menipis</span>
                            </td>
                        </tr>
                        <tr class="border-b bg-white dark:border-gray-700 dark:bg-gray-800">
                            <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">MKN-001</td>
                            <td class="px-4 py-3">Beras Premium 5kg</td>
                            <td class="px-4 py-3">Makanan &amp; Minuman</td>
                            <td class="px-4 py-3 text-right">120</td>
                            <td class="px-4 py-3 text-right">40</td>
                            <td class="px-4 py-3">
                                <span class="rounded bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-300">Aman</span>
                            </td>
                        </tr>
                        <tr class="border-b bg-white dark:border-gray-700 dark:bg-gray-800">
                            <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">ATK-002</td>
                            <td class="px-4 py-3">Pulpen Gel Hitam</td>
                            <td class="px-4 py-3">Alat Tulis Kantor</td>
                            <td class="px-4 py-3 text-right">64</td>
                            <td class="px-4 py-3 text-right">100</td>
                            <td class="px-4 py-3">
                                <span class="rounded bg-red-100 px-2 py-0.5 text-xs font-medium text-red-800 dark:bg-red-900 dark:text-red-300">Menipis</span>
                            </td>
                        </tr>
                        <tr class="bg-white dark:bg-gray-800">
                            <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">RMT-001</td>
                            <td class="px-4 py-3">Sapu Lantai</td>
                            <td class="px-4 py-3">Perlengkapan Rumah Tangga</td>
                            <td class="px-4 py-3 text-right">42</td>
                            <td class="px-4 py-3 text-right">15</td>
                            <td class="px-4 py-3">
                                <span class="rounded bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-300">Aman</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ================================================================ --}}
        {{-- TAB 2: BARANG MASUK --}}
        {{-- ================================================================ --}}
        <div class="hidden rounded-lg" id="tab-masuk" role="tabpanel" aria-labelledby="tab-masuk-btn">

            <div class="mb-4 flex flex-col gap-3 rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800 sm:flex-row sm:items-end sm:justify-between">
                <div class="flex flex-col gap-3 sm:flex-row">
                    <div>
                        <label class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">Dari Tanggal</label>
                        <input type="date" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">Sampai Tanggal</label>
                        <input type="date" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">Status</label>
                        <select class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            <option>Semua Status</option>
                            <option>Diterima</option>
                            <option>Pending</option>
                            <option>Ditolak</option>
                        </select>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button type="button" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                        Export PDF
                    </button>
                    <button type="button" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                        Export Excel
                    </button>
                </div>
            </div>

            <div class="relative overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">SKU</th>
                            <th class="px-4 py-3">Nama Produk</th>
                            <th class="px-4 py-3 text-right">Qty</th>
                            <th class="px-4 py-3">Dicatat Oleh</th>
                            <th class="px-4 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b bg-white dark:border-gray-700 dark:bg-gray-800">
                            <td class="px-4 py-3">03 Agu 2026</td>
                            <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">MKN-002</td>
                            <td class="px-4 py-3">Minyak Goreng 2L</td>
                            <td class="px-4 py-3 text-right">40</td>
                            <td class="px-4 py-3">Budi Santoso</td>
                            <td class="px-4 py-3">
                                <span class="rounded bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-300">Diterima</span>
                            </td>
                        </tr>
                        <tr class="border-b bg-white dark:border-gray-700 dark:bg-gray-800">
                            <td class="px-4 py-3">02 Agu 2026</td>
                            <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">ELK-001</td>
                            <td class="px-4 py-3">Kabel HDMI 2m</td>
                            <td class="px-4 py-3 text-right">25</td>
                            <td class="px-4 py-3">Budi Santoso</td>
                            <td class="px-4 py-3">
                                <span class="rounded bg-yellow-100 px-2 py-0.5 text-xs font-medium text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">Pending</span>
                            </td>
                        </tr>
                        <tr class="bg-white dark:bg-gray-800">
                            <td class="px-4 py-3">01 Agu 2026</td>
                            <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">ATK-001</td>
                            <td class="px-4 py-3">Kertas HVS A4 80gr</td>
                            <td class="px-4 py-3 text-right">15</td>
                            <td class="px-4 py-3">Budi Santoso</td>
                            <td class="px-4 py-3">
                                <span class="rounded bg-red-100 px-2 py-0.5 text-xs font-medium text-red-800 dark:bg-red-900 dark:text-red-300">Ditolak</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ================================================================ --}}
        {{-- TAB 3: BARANG KELUAR --}}
        {{-- ================================================================ --}}
        <div class="hidden rounded-lg" id="tab-keluar" role="tabpanel" aria-labelledby="tab-keluar-btn">

            <div class="mb-4 flex flex-col gap-3 rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800 sm:flex-row sm:items-end sm:justify-between">
                <div class="flex flex-col gap-3 sm:flex-row">
                    <div>
                        <label class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">Dari Tanggal</label>
                        <input type="date" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">Sampai Tanggal</label>
                        <input type="date" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">Status</label>
                        <select class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            <option>Semua Status</option>
                            <option>Dikeluarkan</option>
                            <option>Pending</option>
                        </select>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button type="button" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                        Export PDF
                    </button>
                    <button type="button" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                        Export Excel
                    </button>
                </div>
            </div>

            <div class="relative overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">SKU</th>
                            <th class="px-4 py-3">Nama Produk</th>
                            <th class="px-4 py-3 text-right">Qty</th>
                            <th class="px-4 py-3">Dicatat Oleh</th>
                            <th class="px-4 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b bg-white dark:border-gray-700 dark:bg-gray-800">
                            <td class="px-4 py-3">03 Agu 2026</td>
                            <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">PKN-001</td>
                            <td class="px-4 py-3">Kaos Polos Cotton Combed</td>
                            <td class="px-4 py-3 text-right">6</td>
                            <td class="px-4 py-3">Andi Prasetyo</td>
                            <td class="px-4 py-3">
                                <span class="rounded bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-300">Dikeluarkan</span>
                            </td>
                        </tr>
                        <tr class="border-b bg-white dark:border-gray-700 dark:bg-gray-800">
                            <td class="px-4 py-3">02 Agu 2026</td>
                            <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">ELK-002</td>
                            <td class="px-4 py-3">Power Bank 10000mAh</td>
                            <td class="px-4 py-3 text-right">3</td>
                            <td class="px-4 py-3">Siti Aminah</td>
                            <td class="px-4 py-3">
                                <span class="rounded bg-yellow-100 px-2 py-0.5 text-xs font-medium text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">Pending</span>
                            </td>
                        </tr>
                        <tr class="bg-white dark:bg-gray-800">
                            <td class="px-4 py-3">01 Agu 2026</td>
                            <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">MKN-003</td>
                            <td class="px-4 py-3">Air Mineral 600ml (dus)</td>
                            <td class="px-4 py-3 text-right">10</td>
                            <td class="px-4 py-3">Dedi Kurniawan</td>
                            <td class="px-4 py-3">
                                <span class="rounded bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-300">Dikeluarkan</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ================================================================ --}}
        {{-- TAB 4: AKTIVITAS PENGGUNA --}}
        {{-- ================================================================ --}}
        <div class="hidden rounded-lg" id="tab-aktivitas" role="tabpanel" aria-labelledby="tab-aktivitas-btn">

            <div class="mb-4 flex flex-col gap-3 rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800 sm:flex-row sm:items-end sm:justify-between">
                <div class="flex flex-col gap-3 sm:flex-row">
                    <div>
                        <label class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">Pengguna</label>
                        <select class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            <option>Semua Pengguna</option>
                            <option>Budi Santoso (Manajer Gudang)</option>
                            <option>Andi Prasetyo (Staff Gudang)</option>
                            <option>Siti Aminah (Staff Gudang)</option>
                            <option>Dedi Kurniawan (Staff Gudang)</option>
                        </select>
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">Dari Tanggal</label>
                        <input type="date" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">Sampai Tanggal</label>
                        <input type="date" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    </div>
                </div>
                <div class="flex gap-2">
                    <button type="button" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                        Export PDF
                    </button>
                    <button type="button" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                        Export Excel
                    </button>
                </div>
            </div>

            <div class="relative overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-4 py-3">Waktu</th>
                            <th class="px-4 py-3">Pengguna</th>
                            <th class="px-4 py-3">Role</th>
                            <th class="px-4 py-3">Aktivitas</th>
                            <th class="px-4 py-3">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Baris dummy, nanti diganti @foreach($aktivitas as $log) --}}
                        <tr class="border-b bg-white dark:border-gray-700 dark:bg-gray-800">
                            <td class="px-4 py-3">03 Agu 2026, 14:22</td>
                            <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">Budi Santoso</td>
                            <td class="px-4 py-3">Manajer Gudang</td>
                            <td class="px-4 py-3">
                                <span class="rounded bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-300">Barang Masuk</span>
                            </td>
                            <td class="px-4 py-3">Mencatat penerimaan Minyak Goreng 2L (40 unit)</td>
                        </tr>
                        <tr class="border-b bg-white dark:border-gray-700 dark:bg-gray-800">
                            <td class="px-4 py-3">03 Agu 2026, 10:05</td>
                            <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">Andi Prasetyo</td>
                            <td class="px-4 py-3">Staff Gudang</td>
                            <td class="px-4 py-3">
                                <span class="rounded bg-purple-100 px-2 py-0.5 text-xs font-medium text-purple-800 dark:bg-purple-900 dark:text-purple-300">Barang Keluar</span>
                            </td>
                            <td class="px-4 py-3">Konfirmasi pengeluaran Kaos Polos Cotton Combed (6 unit)</td>
                        </tr>
                        <tr class="bg-white dark:bg-gray-800">
                            <td class="px-4 py-3">02 Agu 2026, 09:41</td>
                            <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">Rina Admin</td>
                            <td class="px-4 py-3">Admin</td>
                            <td class="px-4 py-3">
                                <span class="rounded bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-800 dark:bg-gray-700 dark:text-gray-300">Login</span>
                            </td>
                            <td class="px-4 py-3">Masuk ke sistem</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection