@extends('layouts.dashboard')

@section('content')
<div class="px-4 pt-6">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Import Data Produk</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Unggah berkas CSV/Excel untuk mengimpor atau memperbarui data produk secara masal.</p>
        </div>
        <div>
            <a href="{{ route('products.index') }}" class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                ← Kembali ke Daftar Produk
            </a>
        </div>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800 max-w-2xl">
        <form action="{{ route('products.storeImport') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Upload File -->
            <div>
                <label for="file" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                    Pilih File CSV / Excel <span class="text-red-500">*</span>
                </label>
                <input type="file" name="file" id="file" required accept=".csv,.txt,.xlsx" class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                    Format Kolom CSV: <code class="font-mono text-blue-600 dark:text-blue-400">SKU, Nama Produk, Harga Beli, Harga Jual, Stok Saat Ini, Stok Minimum, Satuan</code>
                </p>
                @error('file')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Download Template Info -->
            <div class="rounded-lg bg-blue-50 p-4 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 text-xs text-blue-800 dark:text-blue-300">
                <p class="font-semibold mb-1">Catatan Penting:</p>
                <ul class="list-disc list-inside space-y-1">
                    <li>Pastikan baris pertama berisi header nama kolom.</li>
                    <li>SKU yang sudah ada di database akan diperbarui secara otomatis.</li>
                </ul>
            </div>

            <!-- Buttons -->
            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Mulai Impor Produk
                </button>
                <a href="{{ route('products.index') }}" class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
