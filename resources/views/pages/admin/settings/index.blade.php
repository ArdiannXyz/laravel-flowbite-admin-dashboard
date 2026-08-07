@extends('layouts.dashboard')

@section('content')
<div class="px-4 pt-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Pengaturan Umum Aplikasi</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">Konfigurasi nama aplikasi, identitas perusahaan, logo, dan profil kontak sistem.</p>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-lg bg-green-50 p-4 text-sm text-green-800 dark:bg-gray-800 dark:text-green-400" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800 max-w-2xl">
        <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nama Aplikasi -->
            <div>
                <label for="app_name" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                    Nama Aplikasi / Sistem <span class="text-red-500">*</span>
                </label>
                <input type="text" name="app_name" id="app_name" value="{{ old('app_name', $settings['app_name']) }}" required placeholder="Stockify Inventory System" class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white @error('app_name') border-red-500 @enderror">
                @error('app_name')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Perusahaan -->
            <div>
                <label for="company_name" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                    Nama Perusahaan / Perusahaan Pemilik <span class="text-red-500">*</span>
                </label>
                <input type="text" name="company_name" id="company_name" value="{{ old('company_name', $settings['company_name']) }}" required placeholder="PT Stockify Utama Indonesia" class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white @error('company_name') border-red-500 @enderror">
                @error('company_name')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Logo Aplikasi -->
            <div>
                <label for="app_logo" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                    Logo Aplikasi / Perusahaan
                </label>
                @if($settings['app_logo'])
                    <div class="mb-3 flex items-center gap-3">
                        <img src="{{ asset('storage/' . $settings['app_logo']) }}" class="h-12 w-auto rounded border p-1" alt="Logo">
                        <span class="text-xs text-gray-500">Logo saat ini terpasang</span>
                    </div>
                @endif
                <input type="file" name="app_logo" id="app_logo" accept="image/*" class="w-full rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Format: PNG, JPG, SVG (Maksimal 2MB).</p>
                @error('app_logo')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Kontak -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="contact_email" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                        Email Kontak
                    </label>
                    <input type="email" name="contact_email" id="contact_email" value="{{ old('contact_email', $settings['contact_email']) }}" placeholder="info@stockify.test" class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                </div>
                <div>
                    <label for="contact_phone" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                        Nomor Telepon
                    </label>
                    <input type="text" name="contact_phone" id="contact_phone" value="{{ old('contact_phone', $settings['contact_phone']) }}" placeholder="0812-3456-7890" class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                </div>
            </div>

            <!-- Alamat Kantor/Gudang -->
            <div>
                <label for="address" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                    Alamat Lengkap Perusahaan
                </label>
                <textarea name="address" id="address" rows="3" placeholder="Alamat lengkap..." class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">{{ old('address', $settings['address']) }}</textarea>
            </div>

            <!-- Buttons -->
            <div class="pt-2">
                <button type="submit" class="rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Simpan Pengaturan Aplikasi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
