@extends('layouts.dashboard')

@section('content')
<div class="p-4">

    {{-- ============ HEADER ============ --}}
    <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-xl font-semibold text-gray-900 dark:text-white">Laporan</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Laporan stok barang dan riwayat transaksi gudang</p>
        </div>
    </div>

    {{-- ============ TABS ============ --}}
    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="-mb-px flex flex-wrap text-center text-sm font-medium" id="laporan-tabs" data-tabs-toggle="#laporan-tab-content" role="tablist">
            <li class="mr-2" role="presentation">
                <button class="inline-block rounded-t-lg border-b-2 p-4" id="tab-stok-btn" data-tabs-target="#tab-stok" type="button" role="tab" aria-controls="tab-stok">
                    Laporan Stok
                </button>
            </li>
            <li class="mr-2" role="presentation">
                <button class="inline-block rounded-t-lg border-b-2 p-4" id="tab-masuk-btn" data-tabs-target="#tab-masuk" type="button" role="tab" aria-controls="tab-masuk">
                    Barang Masuk
                </button>
            </li>
            <li class="mr-2" role="presentation">
                <button class="inline-block rounded-t-lg border-b-2 p-4" id="tab-keluar-btn" data-tabs-target="#tab-keluar" type="button" role="tab" aria-controls="tab-keluar">
                    Barang Keluar
                </button>
            </li>
            {{-- HANYA ADMIN YANG BISA MELIHAT TAB AKTIVITAS --}}
            @role('admin')
            <li role="presentation">
                <button class="inline-block rounded-t-lg border-b-2 p-4" id="tab-aktivitas-btn" data-tabs-target="#tab-aktivitas" type="button" role="tab" aria-controls="tab-aktivitas">
                    Aktivitas Pengguna
                </button>
            </li>
            @endrole
        </ul>
    </div>

    <div id="laporan-tab-content">

        {{-- ================================================================ --}}
        {{-- TAB 1: LAPORAN STOK --}}
        {{-- ================================================================ --}}
        <div class="hidden rounded-lg" id="tab-stok" role="tabpanel" aria-labelledby="tab-stok-btn">

            {{-- Kartu Ringkasan Stok --}}
            <div class="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div class="rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Produk</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $totalProducts }}</p>
                </div>
                <div class="rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Nilai Stok</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">Rp {{ number_format($totalStockValue, 0, ',', '.') }}</p>
                </div>
                <div class="rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Stok di Bawah Minimum</p>
                    <p class="text-2xl font-semibold text-red-600 dark:text-red-500">{{ $lowStockCount }}</p>
                </div>
            </div>

            {{-- Filter Stok --}}
            <form method="GET" action="{{ route('report.index') }}" class="mb-4 flex flex-col gap-3 rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800 sm:flex-row sm:items-end sm:justify-between">
                <div class="flex flex-col gap-3 sm:flex-row">
                    <div>
                        <label class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">Kategori</label>
                        <select name="category_id" onchange="this.form.submit()" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">Status Stok</label>
                        <select name="stock_status" onchange="this.form.submit()" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            <option value="">Semua</option>
                            <option value="aman" {{ request('stock_status') == 'aman' ? 'selected' : '' }}>Aman</option>
                            <option value="menipis" {{ request('stock_status') == 'menipis' ? 'selected' : '' }}>Menipis</option>
                        </select>
                    </div>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('report.export.stok', request()->only(['category_id', 'stock_status'])) }}" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                        Export PDF
                    </a>
                    <a href="{{ route('report.export.stok-excel', request()->only(['category_id', 'stock_status'])) }}" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                        Export Excel
                    </a>
                </div>
            </form>

            {{-- Tabel Stok --}}
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
                        @forelse($stokProducts as $item)
                            <tr class="border-b bg-white dark:border-gray-700 dark:bg-gray-800">
                                <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $item->sku }}</td>
                                <td class="px-4 py-3">{{ $item->name }}</td>
                                <td class="px-4 py-3">{{ $item->category->name ?? '-' }}</td>
                                <td class="px-4 py-3 text-right font-semibold">{{ $item->current_stock }} {{ $item->unit }}</td>
                                <td class="px-4 py-3 text-right">{{ $item->min_stock }} {{ $item->unit }}</td>
                                <td class="px-4 py-3">
                                    @if($item->current_stock < $item->min_stock)
                                        <span class="rounded bg-red-100 px-2 py-0.5 text-xs font-medium text-red-800 dark:bg-red-900 dark:text-red-300">Menipis</span>
                                    @else
                                        <span class="rounded bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-300">Aman</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-4 text-center text-sm text-gray-500">Tidak ada data stok barang.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $stokProducts->links() }}
            </div>
        </div>

        {{-- ================================================================ --}}
        {{-- TAB 2: BARANG MASUK --}}
        {{-- ================================================================ --}}
        <div class="hidden rounded-lg" id="tab-masuk" role="tabpanel" aria-labelledby="tab-masuk-btn">

            <form method="GET" action="{{ route('report.index') }}" class="mb-4 flex flex-col gap-3 rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800 sm:flex-row sm:items-end sm:justify-between">
                <div class="flex flex-col gap-3 sm:flex-row">
                    <div>
                        <label class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">Dari Tanggal</label>
                        <input type="date" name="masuk_from_date" value="{{ request('masuk_from_date') }}" onchange="this.form.submit()" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">Sampai Tanggal</label>
                        <input type="date" name="masuk_to_date" value="{{ request('masuk_to_date') }}" onchange="this.form.submit()" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    </div>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('report.export.masuk', request()->only(['masuk_from_date', 'masuk_to_date'])) }}" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                        Export PDF
                    </a>
                    <a href="{{ route('report.export.masuk-excel', request()->only(['masuk_from_date', 'masuk_to_date'])) }}" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                        Export Excel
                    </a>
                </div>
            </form>

            <div class="relative overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">SKU</th>
                            <th class="px-4 py-3">Nama Produk</th>
                            <th class="px-4 py-3 text-right">Qty</th>
                            <th class="px-4 py-3">Supplier</th>
                            <th class="px-4 py-3">Dicatat Oleh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barangMasuk as $item)
                            <tr class="border-b bg-white dark:border-gray-700 dark:bg-gray-800">
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($item->transaction_date)->translatedFormat('d M Y') }}</td>
                                <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $item->product->sku ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $item->product->name ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-right font-semibold text-green-600">+{{ $item->quantity }}</td>
                                <td class="px-4 py-3">{{ $item->supplier->name ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $item->user->name ?? 'System' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-4 text-center text-sm text-gray-500">Tidak ada riwayat barang masuk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $barangMasuk->links() }}
            </div>
        </div>

        {{-- ================================================================ --}}
        {{-- TAB 3: BARANG KELUAR --}}
        {{-- ================================================================ --}}
        <div class="hidden rounded-lg" id="tab-keluar" role="tabpanel" aria-labelledby="tab-keluar-btn">

            <form method="GET" action="{{ route('report.index') }}" class="mb-4 flex flex-col gap-3 rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800 sm:flex-row sm:items-end sm:justify-between">
                <div class="flex flex-col gap-3 sm:flex-row">
                    <div>
                        <label class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">Dari Tanggal</label>
                        <input type="date" name="keluar_from_date" value="{{ request('keluar_from_date') }}" onchange="this.form.submit()" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">Sampai Tanggal</label>
                        <input type="date" name="keluar_to_date" value="{{ request('keluar_to_date') }}" onchange="this.form.submit()" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    </div>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('report.export.keluar', request()->only(['keluar_from_date', 'keluar_to_date'])) }}" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                        Export PDF
                    </a>
                    <a href="{{ route('report.export.keluar-excel', request()->only(['keluar_from_date', 'keluar_to_date'])) }}" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                        Export Excel
                    </a>
                </div>
            </form>

            <div class="relative overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">SKU</th>
                            <th class="px-4 py-3">Nama Produk</th>
                            <th class="px-4 py-3 text-right">Qty</th>
                            <th class="px-4 py-3">Dicatat Oleh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barangKeluar as $item)
                            <tr class="border-b bg-white dark:border-gray-700 dark:bg-gray-800">
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($item->transaction_date)->translatedFormat('d M Y') }}</td>
                                <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $item->product->sku ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $item->product->name ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-right font-semibold text-red-600">-{{ $item->quantity }}</td>
                                <td class="px-4 py-3">{{ $item->user->name ?? 'System' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-4 text-center text-sm text-gray-500">Tidak ada riwayat barang keluar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $barangKeluar->links() }}
            </div>
        </div>

        {{-- ================================================================ --}}
        {{-- TAB 4: AKTIVITAS PENGGUNA (KHUSUS ADMIN) --}}
        {{-- ================================================================ --}}
        @role('admin')
        <div class="hidden rounded-lg" id="tab-aktivitas" role="tabpanel" aria-labelledby="tab-aktivitas-btn">

            <form method="GET" action="{{ route('report.index') }}" class="mb-4 flex flex-col gap-3 rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800 sm:flex-row sm:items-end sm:justify-between">
                <div class="flex flex-col gap-3 sm:flex-row">
                    <div>
                        <label class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">Pengguna</label>
                        <select name="user_id" onchange="this.form.submit()" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            <option value="">Semua Pengguna</option>
                            @foreach($users as $usr)
                                <option value="{{ $usr->id }}" {{ request('user_id') == $usr->id ? 'selected' : '' }}>
                                    {{ $usr->name }} ({{ ucfirst($usr->role) }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">Dari Tanggal</label>
                        <input type="date" name="act_from_date" value="{{ request('act_from_date') }}" onchange="this.form.submit()" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">Sampai Tanggal</label>
                        <input type="date" name="act_to_date" value="{{ request('act_to_date') }}" onchange="this.form.submit()" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    </div>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('report.export.aktivitas', request()->only(['user_id', 'act_from_date', 'act_to_date'])) }}" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                        Export PDF
                    </a>
                    <a href="{{ route('report.export.aktivitas-excel', request()->only(['user_id', 'act_from_date', 'act_to_date'])) }}" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                        Export Excel
                    </a>
                </div>
            </form>

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
                        @forelse($userActivities as $log)
                            <tr class="border-b bg-white dark:border-gray-700 dark:bg-gray-800">
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($log->created_at)->translatedFormat('d M Y, H:i') }}</td>
                                <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $log->user->name ?? 'System' }}</td>
                                <td class="px-4 py-3 capitalize">{{ $log->user->role ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    @if($log->type === 'in')
                                        <span class="rounded bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-300">Barang Masuk</span>
                                    @else
                                        <span class="rounded bg-purple-100 px-2 py-0.5 text-xs font-medium text-purple-800 dark:bg-purple-900 dark:text-purple-300">Barang Keluar</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    Pencatatan {{ $log->type === 'in' ? 'penerimaan' : 'pengeluaran' }} {{ $log->product->name ?? 'barang' }} ({{ $log->quantity }} unit)
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-4 text-center text-sm text-gray-500">Tidak ada catatan aktivitas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $userActivities->links() }}
            </div>
        </div>
        @endrole

    </div>
</div>
@endsection