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

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8"/>

            </svg>

        </div>

        <h1 class="mt-5 text-3xl font-bold text-gray-900 dark:text-white">

            Konfirmasi Password

        </h1>

        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">

            Demi keamanan akun Anda, masukkan kembali password.

        </p>

    </div>

    {{-- Desktop Header --}}
    <div class="hidden lg:block mb-8">

        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">

            Konfirmasi Password

        </h2>

        <p class="mt-2 text-gray-500 dark:text-gray-400 leading-7">

            Ini adalah area yang aman.
            Sebelum melanjutkan, silakan konfirmasi password akun Anda.

        </p>

    </div>

    <form
        method="POST"
        action="{{ route('password.confirm') }}"
        class="space-y-6"
        x-data="{ showPassword:false, loading:false }"
        @submit="loading=true">

        @csrf

        {{-- PASSWORD --}}
        <div>

            <label
                for="password"
                class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">

                Password

            </label>

            <div class="relative">

                {{-- Lock Icon --}}
                <span
                    class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">

                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8"/>

                    </svg>

                </span>

                {{-- Input --}}
                <input

                    id="password"

                    x-bind:type="showPassword ? 'text' : 'password'"

                    name="password"

                    required

                    autocomplete="current-password"

                    placeholder="••••••••"

                    class="w-full rounded-xl border border-gray-300 bg-gray-50 py-3 pl-11 pr-12
                    text-sm shadow-sm transition
                    focus:border-emerald-500
                    focus:ring-emerald-500
                    dark:bg-gray-700
                    dark:border-gray-600
                    dark:text-white">

                {{-- Toggle Password --}}
                <button

                    type="button"

                    @click="showPassword = !showPassword"

                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-emerald-600 transition">

                    {{-- Eye --}}
                    <svg
                        x-show="!showPassword"
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0"/>

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7"/>

                    </svg>

                    {{-- Eye Off --}}
                    <svg
                        x-show="showPassword"
                        x-cloak
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908A8.98 8.98 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.97 9.97 0 01-2.07 3.522M15 12a3 3 0 11-6 0m6 6L3 3"/>

                    </svg>

                </button>

            </div>

            @error('password')

                <p class="mt-2 text-sm text-red-500">

                    {{ $message }}

                </p>

            @enderror

        </div>

        {{-- Submit --}}
        <button

            type="submit"

            :disabled="loading"

            class="w-full rounded-xl bg-emerald-600 py-3 font-semibold text-white shadow-lg transition duration-300 hover:-translate-y-1 hover:bg-emerald-700 disabled:opacity-70 disabled:cursor-not-allowed">

            <span x-show="!loading">

                Konfirmasi Password

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
                        d="M22 12A10 10 0 0012 2"
                        stroke="currentColor"
                        stroke-width="4"
                        class="opacity-75"/>

                </svg>

                Memverifikasi...

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