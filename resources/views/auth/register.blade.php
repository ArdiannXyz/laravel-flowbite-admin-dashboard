@extends('layouts.guest')

@section('content')

<div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl border border-gray-200 dark:border-gray-700 rounded-3xl shadow-2xl p-8">

    {{-- Mobile Header --}}
    <div class="lg:hidden text-center mb-8">

        <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl bg-emerald-600 shadow-lg">

            <svg class="w-10 h-10 text-white"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24">

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 4v16m8-8H4"/>

            </svg>

        </div>

        <h1 class="mt-5 text-3xl font-bold text-gray-900 dark:text-white">

            Buat Akun

        </h1>

        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">

            Daftarkan akun baru untuk menggunakan Stockify.

        </p>

    </div>

    {{-- Desktop Header --}}
    <div class="hidden lg:block mb-8">

        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">

            Buat Akun Baru

        </h2>

        <p class="mt-2 text-gray-500 dark:text-gray-400">

            Lengkapi data berikut untuk membuat akun baru.

        </p>

    </div>

    <form
        method="POST"
        action="{{ route('register') }}"
        class="space-y-6"
        x-data="{ showPassword:false, showConfirm:false, loading:false }"
        @submit="loading=true">

        @csrf

        {{-- Nama --}}
        <div>

            <label
                for="name"
                class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">

                Nama Lengkap

            </label>

            <div class="relative">

                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">

                    <svg class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5.121 17.804A9 9 0 1118.364 4.56M15 11a3 3 0 11-6 0m6 0a3 3 0 01-6 0"/>

                    </svg>

                </span>

                <input

                    id="name"

                    type="text"

                    name="name"

                    value="{{ old('name') }}"

                    required

                    autofocus

                    autocomplete="name"

                    placeholder="Masukkan nama lengkap"

                    class="w-full rounded-xl border border-gray-300 bg-gray-50 py-3 pl-11 pr-4
                    text-sm shadow-sm
                    focus:border-emerald-500
                    focus:ring-emerald-500
                    dark:bg-gray-700
                    dark:border-gray-600
                    dark:text-white">

            </div>

            @error('name')

                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>

            @enderror

        </div>

        {{-- Email --}}
        <div>

            <label
                for="email"
                class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">

                Email

            </label>

            <div class="relative">

                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">

                    <svg class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M16 12a4 4 0 11-8 0m8 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9"/>

                    </svg>

                </span>

                <input

                    id="email"

                    type="email"

                    name="email"

                    value="{{ old('email') }}"

                    required

                    autocomplete="username"

                    placeholder="admin@stockify.com"

                    class="w-full rounded-xl border border-gray-300 bg-gray-50 py-3 pl-11 pr-4
                    text-sm shadow-sm
                    focus:border-emerald-500
                    focus:ring-emerald-500
                    dark:bg-gray-700
                    dark:border-gray-600
                    dark:text-white">

            </div>

            @error('email')

                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>

            @enderror

        </div>

        {{-- Password --}}
        <div>

            <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">

                Password

            </label>

            <div class="relative">

                <input

                    x-bind:type="showPassword ? 'text' : 'password'"

                    name="password"

                    required

                    autocomplete="new-password"

                    placeholder="••••••••"

                    class="w-full rounded-xl border border-gray-300 bg-gray-50 py-3 px-4 pr-12
                    text-sm shadow-sm
                    focus:border-emerald-500
                    focus:ring-emerald-500
                    dark:bg-gray-700
                    dark:border-gray-600
                    dark:text-white">

                <button
                    type="button"
                    @click="showPassword=!showPassword"
                    class="absolute right-4 top-3 text-gray-400 hover:text-emerald-600">

                    <span x-show="!showPassword">👁</span>
                    <span x-show="showPassword">🙈</span>

                </button>

            </div>

            @error('password')

                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>

            @enderror

        </div>

        {{-- Konfirmasi Password --}}
        <div>

            <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">

                Konfirmasi Password

            </label>

            <div class="relative">

                <input

                    x-bind:type="showConfirm ? 'text' : 'password'"

                    name="password_confirmation"

                    required

                    autocomplete="new-password"

                    placeholder="••••••••"

                    class="w-full rounded-xl border border-gray-300 bg-gray-50 py-3 px-4 pr-12
                    text-sm shadow-sm
                    focus:border-emerald-500
                    focus:ring-emerald-500
                    dark:bg-gray-700
                    dark:border-gray-600
                    dark:text-white">

                <button
                    type="button"
                    @click="showConfirm=!showConfirm"
                    class="absolute right-4 top-3 text-gray-400 hover:text-emerald-600">

                    <span x-show="!showConfirm">👁</span>
                    <span x-show="showConfirm">🙈</span>

                </button>

            </div>

            @error('password_confirmation')

                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>

            @enderror

        </div>

        {{-- Button --}}
        <button

            type="submit"

            :disabled="loading"

            class="w-full rounded-xl bg-emerald-600 py-3 font-semibold text-white shadow-lg transition duration-300 hover:-translate-y-1 hover:bg-emerald-700 disabled:opacity-70">

            <span x-show="!loading">

                Buat Akun

            </span>

            <span
                x-show="loading"
                class="flex items-center justify-center gap-2">

                <svg class="animate-spin h-5 w-5"
                    viewBox="0 0 24 24"
                    fill="none">

                    <circle
                        cx="12"
                        cy="12"
                        r="10"
                        stroke="currentColor"
                        stroke-width="4"
                        class="opacity-25"/>

                    <path
                        d="M22 12A10 10 0 0012 2"
                        stroke="currentColor"
                        stroke-width="4"
                        class="opacity-75"/>

                </svg>

                Membuat Akun...

            </span>

        </button>

        <div class="text-center">

            <a
                href="{{ route('login') }}"
                class="text-sm font-medium text-emerald-600 hover:underline">

                Sudah punya akun? Masuk

            </a>

        </div>

    </form>

    <div class="mt-8 border-t pt-5">

        <p class="text-center text-xs text-gray-400">

            © {{ date('Y') }} Stockify • Inventory Management System

        </p>

    </div>

</div>

@endsection