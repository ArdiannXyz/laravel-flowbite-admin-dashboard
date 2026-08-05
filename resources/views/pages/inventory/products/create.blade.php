@extends('layouts.dashboard')

@section('content')
<div class="px-4 pt-6">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Tambah Produk Baru</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Isi formulir berikut untuk mendaftarkan barang baru ke dalam gudang.</p>
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
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <!-- SKU -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Kode SKU (Kosongkan jika auto-generate)</label>
                    <input type="text" name="sku" value="{{ old('sku') }}" placeholder="PRD-ELK-001" class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                </div>

                <!-- Nama Produk -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Barcode Scanner Wireless" class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                </div>

                <!-- Kategori -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Kategori <span class="text-red-500">*</span></label>
                    <select name="category_id" required class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
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
                            <option value="{{ $sup->id }}" {{ old('supplier_id') == $sup->id ? 'selected' : '' }}>
                                {{ $sup->name }} ({{ $sup->code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Harga Beli -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Harga Beli (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" name="buy_price" value="{{ old('buy_price', 0) }}" required class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                </div>

                <!-- Harga Jual -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Harga Jual (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" name="sell_price" value="{{ old('sell_price', 0) }}" required class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                </div>

                <!-- Stok Awal -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Stok Awal <span class="text-red-500">*</span></label>
                    <input type="number" name="current_stock" value="{{ old('current_stock', 0) }}" required class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                </div>

                <!-- Stok Minimum Alert Threshold -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Stok Minimum (Batas Alert) <span class="text-red-500">*</span></label>
                    <input type="number" name="min_stock" value="{{ old('min_stock', 5) }}" required class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                </div>

                <!-- Satuan -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Satuan (Unit) <span class="text-red-500">*</span></label>
                    <select name="unit" required class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <option value="unit" {{ old('unit', 'unit') == 'unit' ? 'selected' : '' }}>unit</option>
                        <option value="pcs" {{ old('unit') == 'pcs' ? 'selected' : '' }}>pcs</option>
                        <option value="box" {{ old('unit') == 'box' ? 'selected' : '' }}>box</option>
                        <option value="roll" {{ old('unit') == 'roll' ? 'selected' : '' }}>roll</option>
                    </select>
                </div>

                <!-- Gambar Produk -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Gambar Produk</label>
                    <div class="flex items-center">
                        <label for="image_input" class="flex h-10 w-full cursor-pointer items-center overflow-hidden rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 focus-within:border-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            <span class="flex h-full items-center bg-gray-800 px-4 text-xs font-semibold text-white hover:bg-gray-700 dark:bg-gray-600">Pilih Gambar</span>
                            <span id="file_name_display" class="px-3 text-xs text-gray-500 dark:text-gray-400 truncate">Belum ada gambar dipilih</span>
                            <input type="file" name="image" id="image_input" accept="image/*" class="hidden" onchange="document.getElementById('file_name_display').textContent = this.files[0] ? this.files[0].name : 'Belum ada gambar dipilih'">
                        </label>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Deskripsi Produk</label>
                    <textarea name="description" rows="3" class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white" placeholder="Catatan atau rincian spesifikasi produk...">{{ old('description') }}</textarea>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('products.index') }}" class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                    Batal
                </a>
                <button type="submit" class="rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Simpan Produk
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
