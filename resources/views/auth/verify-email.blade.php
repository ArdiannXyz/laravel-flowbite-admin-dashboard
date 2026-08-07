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
                    d="M3 8l9 6 9-6m-18 0v8a2 2 0 002 2h14a2 2 0 002-2V8"/>

            </svg>

        </div>

        <h1 class="mt-5 text-3xl font-bold text-gray-900 dark:text-white">

            Verifikasi Email

        </h1>

        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">

            Hampir selesai! Verifikasi email Anda.

        </p>

    </div>

    {{-- Desktop Header --}}
    <div class="hidden lg:block mb-8">

        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">

            Verifikasi Email

        </h2>

        <p class="mt-2 text-gray-500 dark:text-gray-400 leading-7">

            Terima kasih telah mendaftar.
            Sebelum melanjutkan, silakan verifikasi alamat email Anda
            melalui link yang telah kami kirimkan.

        </p>

    </div>

    {{-- Success Message --}}
    @if (session('status') == 'verification-link-sent')

        <div
            class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 dark:border-green-700 dark:bg-green-900/30 dark:text-green-300">

            Link verifikasi baru berhasil dikirim ke alamat email Anda.

        </div>

    @endif

    <div class="space-y-5">

        {{-- Resend Email --}}
        <form
            method="POST"
            action="{{ route('verification.send') }}"
            x-data="{ loading:false }"
            @submit="loading=true">

            @csrf

            <button

                type="submit"

                :disabled="loading"

                class="w-full rounded-xl bg-emerald-600 py-3 font-semibold text-white shadow-lg transition duration-300 hover:-translate-y-1 hover:bg-emerald-700 disabled:opacity-70">

                <span x-show="!loading">

                    Kirim Ulang Email Verifikasi

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

                    Mengirim...

                </span>

            </button>

        </form>

        {{-- Logout --}}
        <form
            method="POST"
            action="{{ route('logout') }}">

            @csrf

            <button

                type="submit"

                class="w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 py-3 font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 transition">

                Keluar dari Akun

            </button>

        </form>

    </div>

    {{-- Footer --}}
    <div class="mt-8 border-t pt-5">

        <p class="text-center text-xs text-gray-400">

            © {{ date('Y') }} Stockify • Inventory Management System

        </p>

    </div>

</div>

@endsection