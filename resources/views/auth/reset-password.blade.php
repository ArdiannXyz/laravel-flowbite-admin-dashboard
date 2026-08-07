@extends('layouts.guest')

@section('content')

<div
    class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl border border-gray-200 dark:border-gray-700 rounded-3xl shadow-2xl p-8">

    {{-- Mobile Header --}}
    <div class="lg:hidden text-center mb-8">

        <div
            class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl bg-emerald-600 shadow-lg">

            <svg class="w-10 h-10 text-white"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24">

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8"/>

            </svg>

        </div>

        <h1 class="mt-5 text-3xl font-bold text-gray-900 dark:text-white">

            Reset Password

        </h1>

        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">

            Buat password baru untuk akun Anda.

        </p>

    </div>

    {{-- Desktop Header --}}
    <div class="hidden lg:block mb-8">

        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">

            Buat Password Baru

        </h2>

        <p class="mt-2 text-gray-500 dark:text-gray-400">

            Password baru harus aman dan mudah Anda ingat.

        </p>

    </div>

    <form
        method="POST"
        action="{{ route('password.store') }}"
        class="space-y-6"
        x-data="{ showPassword:false, showConfirm:false, loading:false }"
        @submit="loading=true">

        @csrf

        {{-- TOKEN --}}
        <input
            type="hidden"
            name="token"
            value="{{ $request->route('token') }}">

        {{-- EMAIL --}}
        <div>

            <label
                for="email"
                class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">

                Email

            </label>

            <input

                id="email"

                type="email"

                name="email"

                value="{{ old('email', $request->email) }}"

                required

                autocomplete="username"

                class="w-full rounded-xl border border-gray-300 bg-gray-50 py-3 px-4
                text-sm shadow-sm transition
                focus:border-emerald-500
                focus:ring-emerald-500
                dark:bg-gray-700
                dark:border-gray-600
                dark:text-white">

            @error('email')

                <p class="mt-2 text-sm text-red-500">

                    {{ $message }}

                </p>

            @enderror

        </div>

        {{-- PASSWORD --}}
        <div>

            <label
                class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">

                Password Baru

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

                    👁

                </button>

            </div>

            @error('password')

                <p class="mt-2 text-sm text-red-500">

                    {{ $message }}

                </p>

            @enderror

        </div>

        {{-- CONFIRM PASSWORD --}}
        <div>

            <label
                class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">

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

                    👁

                </button>

            </div>

            @error('password_confirmation')

                <p class="mt-2 text-sm text-red-500">

                    {{ $message }}

                </p>

            @enderror

        </div>

        {{-- BUTTON --}}
        <button

            type="submit"

            :disabled="loading"

            class="w-full rounded-xl bg-emerald-600 py-3 font-semibold text-white shadow-lg transition duration-300 hover:-translate-y-1 hover:bg-emerald-700 disabled:opacity-70 disabled:cursor-not-allowed">

            <span
                x-show="!loading">

                Reset Password

            </span>

            <span
                x-show="loading"
                class="flex items-center justify-center gap-2">

                <svg
                    class="animate-spin h-5 w-5"
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
                        d="M22 12a10 10 0 00-10-10"
                        stroke="currentColor"
                        stroke-width="4"
                        class="opacity-75"/>

                </svg>

                Memproses...

            </span>

        </button>

    </form>

    <div class="mt-8 border-t pt-5">

        <p class="text-center text-xs text-gray-400">

            © {{ date('Y') }} Stockify • Inventory Management System

        </p>

    </div>

</div>

@endsection