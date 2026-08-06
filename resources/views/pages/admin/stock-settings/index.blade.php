@extends('layouts.dashboard')

@section('content')
<div class="px-4 pt-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Pengaturan Stok Minimum & Notifikasi</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">Atur ambang batas stok minimum standar dan preferensi peringatan restock otomatis.</p>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-lg bg-green-50 p-4 text-sm text-green-800 dark:bg-gray-800 dark:text-green-400" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800 max-w-2xl">
        <form action="{{ route('stock-settings.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Default Minimum Stock -->
            <div>
                <label for="default_min_stock" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                    Stok Minimum Default Per Produk <span class="text-red-500">*</span>
                </label>
                <input type="number" name="default_min_stock" id="default_min_stock" value="{{ old('default_min_stock', $setting->default_min_stock) }}" required min="1" class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white @error('default_min_stock') border-red-500 @enderror">
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Jumlah batas minimum default saat membuat produk baru.</p>
                @error('default_min_stock')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Notification Address -->
            <div>
                <label for="notification_email" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                    Email Penerima Notifikasi Peringatan Stok
                </label>
                <input type="email" name="notification_email" id="notification_email" value="{{ old('notification_email', $setting->notification_email) }}" placeholder="admin@stockify.test" class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white @error('notification_email') border-red-500 @enderror">
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Email yang akan menerima alert saat ada barang yang menipis.</p>
                @error('notification_email')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Auto Notification Checkbox -->
            <div class="flex items-center">
                <input type="checkbox" name="auto_notify_low_stock" id="auto_notify_low_stock" value="1" {{ old('auto_notify_low_stock', $setting->auto_notify_low_stock) ? 'checked' : '' }} class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800">
                <label for="auto_notify_low_stock" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                    Aktifkan Peringatan Otomatis (Alert Status Menipis di Dashboard)
                </label>
            </div>

            <!-- Buttons -->
            <div class="pt-2">
                <button type="submit" class="rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Simpan Pengaturan Stok
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
