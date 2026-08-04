@extends('layouts.dashboard')

@section('content')
<div class="px-4 pt-6">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Form Penerimaan Barang (Barang Masuk)</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Pencatatan penerimaan stok akan otomatis menambahkan kuantitas stok produk.</p>
        </div>
        <a href="{{ route('stock-in.index') }}" class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">
            ← Kembali
        </a>
    </div>

    @if(session('error'))
        <div class="mb-6 rounded-lg bg-red-50 p-4 text-sm text-red-800 dark:bg-gray-800 dark:text-red-400">
            {{ session('error') }}
        </div>
    @endif

    <div class="max-w-3xl rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <form action="{{ route('stock-in.store') }}" method="POST">
            @csrf
            <div class="space-y-6">
                <!-- Produk -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Pilih Produk <span class="text-red-500">*</span></label>
                    <select name="product_id" required class="w-full rounded-lg border border-gray-300 bg-gray-50 p-3 text-sm text-gray-900 focus:border-green-500 focus:ring-green-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <option value="">-- Pilih Produk --</option>
                        @foreach($products as $p)
                            <option value="{{ $p->id }}" {{ (old('product_id') ?? $selectedProductId) == $p->id ? 'selected' : '' }}>
                                {{ $p->name }} (SKU: {{ $p->sku }} | Stok Saat Ini: {{ $p->current_stock }} {{ $p->unit }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Supplier -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Supplier Pengirim</label>
                    <select name="supplier_id" class="w-full rounded-lg border border-gray-300 bg-gray-50 p-3 text-sm text-gray-900 focus:border-green-500 focus:ring-green-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <option value="">-- Gunakan Supplier bawaan produk --</option>
                        @foreach($suppliers as $sup)
                            <option value="{{ $sup->id }}" {{ old('supplier_id') == $sup->id ? 'selected' : '' }}>
                                {{ $sup->name }} ({{ $sup->code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Jumlah & Harga -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Jumlah Barang Masuk <span class="text-red-500">*</span></label>
                        <input type="number" min="1" name="quantity" value="{{ old('quantity', 1) }}" required class="w-full rounded-lg border border-gray-300 bg-gray-50 p-3 text-sm text-gray-900 focus:border-green-500 focus:ring-green-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Harga Beli Per Satuan (Rp)</label>
                        <input type="number" step="0.01" name="unit_price" value="{{ old('unit_price') }}" placeholder="Default harga beli produk" class="w-full rounded-lg border border-gray-300 bg-gray-50 p-3 text-sm text-gray-900 focus:border-green-500 focus:ring-green-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    </div>
                </div>

                <!-- Tanggal Transaksi -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Tanggal Penerimaan <span class="text-red-500">*</span></label>
                    <input type="date" name="transaction_date" value="{{ old('transaction_date', date('Y-m-d')) }}" required class="w-full rounded-lg border border-gray-300 bg-gray-50 p-3 text-sm text-gray-900 focus:border-green-500 focus:ring-green-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                </div>

                <!-- Catatan / No PO -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Catatan / Referensi Surat Jalan</label>
                    <textarea name="notes" rows="3" placeholder="Contoh: Surat Jalan No. SJ-8891 dari supplier" class="w-full rounded-lg border border-gray-300 bg-gray-50 p-3 text-sm text-gray-900 focus:border-green-500 focus:ring-green-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">{{ old('notes') }}</textarea>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t dark:border-gray-700">
                    <a href="{{ route('stock-in.index') }}" class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">
                        Batal
                    </a>
                    <button type="submit" class="rounded-lg bg-green-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-300 dark:focus:ring-green-800">
                        Simpan & Tambah Stok
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
