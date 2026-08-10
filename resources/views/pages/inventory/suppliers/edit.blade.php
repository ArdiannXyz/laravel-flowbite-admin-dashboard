@extends('layouts.dashboard')

@section('content')
<div class="px-4 pt-6">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Edit Supplier: {{ $supplier->name }}</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Memperbarui informasi profil dan kontak data supplier.</p>
        </div>
        <a href="{{ route('suppliers.index') }}" class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">
            ← Kembali ke Daftar Supplier
        </a>
    </div>

    @if(session('error'))
        <div class="mb-6 rounded-lg bg-red-50 p-4 text-sm text-red-800 dark:bg-gray-800 dark:text-red-400">
            {{ session('error') }}
        </div>
    @endif

    <div class="max-w-3xl rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST" data-confirm-edit="Apakah Anda yakin ingin menyimpan perubahan pada supplier '{{ $supplier->name }}'?" data-confirm-title="Simpan Perubahan Supplier">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <!-- Kode & Nama Supplier -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Kode Supplier</label>
                        <input type="text" value="{{ $supplier->code }}" disabled
                            class="w-full rounded-lg border border-gray-300 bg-gray-100 p-3 text-sm text-gray-500 cursor-not-allowed dark:border-gray-600 dark:bg-gray-600 dark:text-gray-400">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Kode supplier tidak dapat diubah setelah dibuat.</p>
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Nama Supplier / Perusahaan <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $supplier->name) }}" required placeholder="Contoh: PT Jaya Elektrosindo" class="w-full rounded-lg border border-gray-300 bg-gray-50 p-3 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        @error('name')
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Email & Telepon -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Email Kontak</label>
                        <input type="email" name="email" value="{{ old('email', $supplier->email) }}" placeholder="Contoh: sales@supplier.co.id" class="w-full rounded-lg border border-gray-300 bg-gray-50 p-3 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        @error('email')
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">No. Telepon / WhatsApp</label>
                        <input type="text" name="phone" value="{{ old('phone', $supplier->phone) }}" placeholder="Contoh: 0812-3456-7890" class="w-full rounded-lg border border-gray-300 bg-gray-50 p-3 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        @error('phone')
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Alamat -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Alamat Lengkap Kantor / Gudang</label>
                    <textarea name="address" rows="3" placeholder="Alamat lengkap lokasi supplier..." class="w-full rounded-lg border border-gray-300 bg-gray-50 p-3 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">{{ old('address', $supplier->address) }}</textarea>
                    @error('address')
                        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t dark:border-gray-700">
                    <a href="{{ route('suppliers.index') }}" class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">
                        Batal
                    </a>
                    <button type="submit" class="rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Perbarui Supplier
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
