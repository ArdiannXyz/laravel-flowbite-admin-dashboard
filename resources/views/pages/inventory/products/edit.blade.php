@extends('layouts.dashboard')

@section('content')
<div class="px-4 pt-6">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Edit Produk: {{ $product->name }}</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Perbarui data atribut, harga, atau stok minimum produk.</p>
        </div>
        <a href="{{ route('products.index') }}" class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
            ← Kembali
        </a>
    </div>

    @if($errors->any())
        <div class="mb-6 rounded-lg bg-red-50 p-4 text-sm text-red-800 dark:bg-gray-800 dark:text-red-400">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" data-confirm-edit="Apakah Anda yakin ingin menyimpan perubahan pada produk '{{ $product->name }}'?" data-confirm-title="Simpan Perubahan Produk">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <!-- SKU -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Kode SKU</label>
                    <input type="text" value="{{ $product->sku }}" disabled
                        class="w-full rounded-lg border border-gray-300 bg-gray-100 p-2.5 text-sm text-gray-500 cursor-not-allowed dark:border-gray-600 dark:bg-gray-600 dark:text-gray-400">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">SKU tidak dapat diubah setelah produk dibuat.</p>
                </div>

                <!-- Nama Produk -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                </div>

                <!-- Kategori -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Kategori <span class="text-red-500">*</span></label>
                    <select name="category_id" required class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Supplier -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Supplier Utama</label>
                    <select name="supplier_id" class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <option value="">Pilih Supplier (Opsional)</option>
                        @foreach($suppliers as $sup)
                            <option value="{{ $sup->id }}" {{ old('supplier_id', $product->supplier_id) == $sup->id ? 'selected' : '' }}>
                                {{ $sup->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Harga Beli -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Harga Beli (Rp)</label>
                    <input type="number" step="0.01" name="buy_price" value="{{ old('buy_price', $product->buy_price) }}" required class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                </div>

                <!-- Harga Jual -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Harga Jual (Rp)</label>
                    <input type="number" step="0.01" name="sell_price" value="{{ old('sell_price', $product->sell_price) }}" required class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                </div>

                <!-- Stok Saat Ini -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Stok Saat Ini</label>
                    <input type="number" name="current_stock" value="{{ old('current_stock', $product->current_stock) }}" required class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                </div>

                <!-- Stok Minimum -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Stok Minimum (Alert)</label>
                    <input type="number" name="min_stock" value="{{ old('min_stock', $product->min_stock) }}" required class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                </div>

                <!-- Satuan -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Satuan (Unit)</label>
                    <input type="text" name="unit" value="{{ old('unit', $product->unit) }}" required class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                </div>

                <!-- Gambar -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Ganti Gambar Produk</label>
                    <input type="file" name="image" accept="image/*" class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                </div>

                <!-- Deskripsi -->
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Deskripsi Produk</label>
                    <textarea name="description" rows="3" class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">{{ old('description', $product->description) }}</textarea>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('products.index') }}" class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                    Batal
                </a>
                <button type="submit" class="rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Perbarui Produk
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
