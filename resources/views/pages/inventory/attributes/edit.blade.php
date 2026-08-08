@extends('layouts.dashboard')

@section('content')
<div class="px-4 pt-6">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Edit Atribut Produk: {{ $attribute->name }}</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Perbarui spesifikasi atau varian atribut produk ini.</p>
        </div>
        <div>
            <a href="{{ route('attributes.index') }}" class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                ← Kembali ke Daftar Atribut
            </a>
        </div>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800 max-w-2xl">
        <form action="{{ route('attributes.update', $attribute->id) }}" method="POST" data-confirm-edit="Apakah Anda yakin ingin menyimpan perubahan pada atribut '{{ $attribute->name }}'?" data-confirm-title="Simpan Perubahan Atribut" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nama Atribut -->
            <div>
                <label for="name" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                    Nama Atribut <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name', $attribute->name) }}" required placeholder="Contoh: Ukuran, Warna, Berat" class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Pilihan / Nilai -->
            <div>
                <label for="values" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                    Pilihan / Nilai Varian (Pisahkan dengan koma)
                </label>
                <input type="text" name="values" id="values" value="{{ old('values', $attribute->values) }}" placeholder="Contoh: S, M, L, XL atau Merah, Biru, Hitam" class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 @error('values') border-red-500 @enderror">
                @error('values')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Perbarui Atribut
                </button>
                <a href="{{ route('attributes.index') }}" class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
