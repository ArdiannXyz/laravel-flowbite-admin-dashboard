@extends('layouts.dashboard')

@section('content')
<div class="px-4 pt-6">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Form Stock Opname (Pemeriksaan Fisik Stok)</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Pencatatan hasil hitung fisik barang. Stok di sistem akan disesuaikan secara otomatis sesuai hasil opname.</p>
        </div>
        <a href="{{ route('stock-opname.index') }}" class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">
            ← Kembali
        </a>
    </div>

    @if(session('error'))
        <div class="mb-6 rounded-lg bg-red-50 p-4 text-sm text-red-800 dark:bg-gray-800 dark:text-red-400">
            {{ session('error') }}
        </div>
    @endif

    <div class="max-w-3xl rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <form action="{{ route('stock-opname.store') }}" method="POST">
            @csrf
            <div class="space-y-6">
                <!-- Pilih Produk -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Pilih Produk <span class="text-red-500">*</span></label>
                    <select name="product_id" id="product_select" required class="w-full rounded-lg border border-gray-300 bg-gray-50 p-3 text-sm text-gray-900 focus:border-purple-500 focus:ring-purple-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <option value="">-- Pilih Produk yang Diperiksa --</option>
                        @foreach($products as $p)
                            <option value="{{ $p->id }}" {{ (old('product_id') ?? $selectedProductId) == $p->id ? 'selected' : '' }}>
                                {{ $p->name }} (SKU: {{ $p->sku }} | Stok Sistem: {{ $p->current_stock }} {{ $p->unit }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Input Stok Fisik -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Hasil Penghitungan Stok Fisik <span class="text-red-500">*</span></label>
                    <input type="number" min="0" name="physical_stock" value="{{ old('physical_stock', 0) }}" required placeholder="Jumlah riil di lokasi gudang" class="w-full rounded-lg border border-gray-300 bg-gray-50 p-3 text-sm text-gray-900 focus:border-purple-500 focus:ring-purple-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Masukkan total fisik barang yang dihitung nyata di rak gudang.</p>
                </div>

                <!-- Tanggal Opname -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Tanggal Audit Opname <span class="text-red-500">*</span></label>
                    <input type="date" name="opname_date" value="{{ old('opname_date', date('Y-m-d')) }}" required class="w-full rounded-lg border border-gray-300 bg-gray-50 p-3 text-sm text-gray-900 focus:border-purple-500 focus:ring-purple-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                </div>

                <!-- Catatan / Alasan Selisih -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Alasan Selisih / Catatan Audit</label>
                    <textarea name="notes" rows="3" placeholder="Contoh: Terjadi kerusakan fisik barang 2 unit / Salah pencatatan sebelumnya" class="w-full rounded-lg border border-gray-300 bg-gray-50 p-3 text-sm text-gray-900 focus:border-purple-500 focus:ring-purple-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">{{ old('notes') }}</textarea>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t dark:border-gray-700">
                    <a href="{{ route('stock-opname.index') }}" class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">
                        Batal
                    </a>
                    <button type="submit" class="rounded-lg bg-purple-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-4 focus:ring-purple-300 dark:focus:ring-purple-800">
                        Simpan & Singkronkan Stok
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
