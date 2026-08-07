@extends('layouts.guest')

@section('content')
<div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl border border-gray-200 dark:border-gray-700 rounded-3xl shadow-2xl p-8">

    {{-- Logo Mobile --}}
    <div class="lg:hidden text-center mb-8">
        <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl bg-emerald-600 shadow-lg">
            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 11c0-3.866 3.134-7 7-7m-7 7c0 3.866-3.134 7-7 7m7-7V3m0 8h8m-8 0H4" />
            </svg>
        </div>
        <h1 class="mt-5 text-3xl font-bold text-gray-900 dark:text-white">Lupa Password?</h1>
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
            Kami akan mengirimkan link reset password ke email Anda.
        </p>
    </div>

    {{-- Desktop Header --}}
    <div class="hidden lg:block mb-8">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Lupa Password?</h2>
        <p class="mt-2 text-gray-500 dark:text-gray-400 leading-7">
            Tidak masalah. Masukkan alamat email yang terdaftar,
            kemudian kami akan mengirimkan tautan untuk membuat password baru.
        </p>
    </div>

    {{-- Session Status --}}
    @if (session('status'))
        <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 dark:border-green-700 dark:bg-green-900/30 dark:text-green-300">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        {{-- Email --}}
        <div>
            <label for="email" class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-300">
                Alamat Email
            </label>

            <div class="relative">
                <span class="absolute left-4 top-3.5 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 12a4 4 0 11-8 0 4 4 0 018 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </span>

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    placeholder="admin@stockify.com"
                    class="w-full rounded-xl border border-gray-300 bg-gray-50 py-3 pl-11 pr-4 text-sm shadow-sm transition focus:border-emerald-500 focus:ring-emerald-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>

            @error('email')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Submit --}}
        <button type="submit"
            class="group w-full rounded-xl bg-emerald-600 py-3 font-semibold text-white shadow-lg transition duration-300 hover:-translate-y-1 hover:bg-emerald-700">
            <span class="flex items-center justify-center gap-2">
                Kirim Link Reset Password
                <svg class="w-5 h-5 transition group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </span>
        </button>
    </form>

    {{-- Back Login --}}
    <div class="mt-6 text-center">
        <a href="{{ route('login') }}" class="text-sm font-medium text-emerald-600 hover:text-emerald-700 hover:underline">
            ← Kembali ke Login
        </a>
    </div>

    <div class="mt-8 border-t pt-5">
        <p class="text-center text-xs text-gray-400">
            © {{ date('Y') }} Stockify • Inventory Management System
        </p>
    </div>
</div>
@endsection