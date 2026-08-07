@extends('layouts.dashboard')

@section('content')
<div class="px-4 pt-6">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Tambah Pengguna Baru</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Buat akun pengguna baru untuk mengelola sistem inventaris.</p>
        </div>
        <div>
            <a href="{{ route('users.index') }}" class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                ← Kembali ke Daftar Pengguna
            </a>
        </div>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800 max-w-2xl">
        <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Nama Pengguna -->
            <div>
                <label for="name" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="Contoh: Ahmad Subagyo" class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                    Alamat Email <span class="text-red-500">*</span>
                </label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="email@stockify.test" class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div x-data="{ showPassword: false }">
                <label for="password" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                    Kata Sandi (Password) <span class="text-red-500">*</span>
                </label>

                <div class="relative">
                    <input
                        :type="showPassword ? 'text' : 'password'"
                        name="password"
                        id="password"
                        required
                        placeholder="Minimal 8 karakter"
                        class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 pr-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 @error('password') border-red-500 @enderror"
                    >

                    <button
                        type="button"
                        @click="showPassword = !showPassword"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-white focus:outline-none transition-colors"
                        tabindex="-1"
                    >
                        <!-- Icon: Mata terbuka (tampilkan password) -->
                        <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                        </svg>

                        <!-- Icon: Mata tercoret (sembunyikan password) -->
                        <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" style="display: none;">
                            <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" />
                            <path d="M2.458 10c.294.943.744 1.813 1.32 2.577l1.473-1.473a4.007 4.007 0 01-.72-1.104A9.958 9.958 0 012.458 10zM10 17c1.63 0 3.14-.446 4.436-1.222l-1.475-1.475A5.968 5.968 0 0110 15a5.972 5.972 0 01-2.938-.775l-1.475 1.474A9.958 9.958 0 0010 17z" />
                        </svg>
                    </button>
                </div>

                @error('password')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Peran (Role) -->
            <div>
                <label for="role" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                    Peran Pengguna (Role) <span class="text-red-500">*</span>
                </label>
                <select name="role" id="role" required class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator (Akses Penuh)</option>
                    <option value="manajer" {{ old('role') == 'manajer' ? 'selected' : '' }}>Manajer Gudang (Akses Operasional & Laporan)</option>
                    <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff Gudang (Konfirmasi Transaksi)</option>
                </select>
                @error('role')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Simpan Pengguna
                </button>
                <a href="{{ route('users.index') }}" class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection