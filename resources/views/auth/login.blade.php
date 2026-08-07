@extends('layouts.guest')

@section('content')

<div
    class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl border border-gray-200 dark:border-gray-700 rounded-3xl shadow-2xl p-8">

    {{-- Logo Mobile --}}
    <div class="lg:hidden text-center mb-8">

        <div
            class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl bg-emerald-600 shadow-lg">

            <svg class="w-10 h-10 text-white"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24">

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M20 7L12 3L4 7M20 7L12 11M20 7V17L12 21M12 11L4 7M12 11V21M4 7V17L12 21"/>

            </svg>

        </div>

        <h1 class="mt-5 text-3xl font-bold text-gray-900 dark:text-white">

            Stockify

        </h1>

        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">

            Inventory Management System

        </p>

    </div>

    {{-- Desktop Header --}}

    <div class="hidden lg:block mb-8">

        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">

            Selamat Datang 👋

        </h2>

        <p class="mt-2 text-gray-500 dark:text-gray-400">

            Masukkan email dan password untuk masuk ke dashboard.

        </p>

    </div>

    {{-- Session Status --}}
    @if (session('status'))

        <div
            class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 dark:border-green-700 dark:bg-green-900/30 dark:text-green-300">

            {{ session('status') }}

        </div>

    @endif

    {{-- Error Login --}}
    @if ($errors->any())

        <div
            class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 dark:border-red-700 dark:bg-red-900/30 dark:text-red-300">

            {{ $errors->first() }}

        </div>

    @endif

    <form
        method="POST"
        action="{{ route('login') }}"
        class="space-y-6">

        @csrf

        {{-- EMAIL --}}
        <div>

            <label
                class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-300">

                Email

            </label>

            <div class="relative">

                <span
                    class="absolute left-4 top-3.5 text-gray-400">

                    <svg
                        class="w-5 h-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M16 12a4 4 0 11-8 0
                            4 4 0 018 0zm0 0v1.5a2.5
                            2.5 0 005 0V12a9 9 0
                            10-9 9m4.5-1.206a8.959
                            8.959 0 01-4.5 1.207"/>

                    </svg>

                </span>

                <input

                    type="email"

                    id="email"

                    name="email"

                    value="{{ old('email') }}"

                    required

                    autofocus

                    autocomplete="username"

                    placeholder="admin@stockify.com"

                    class="w-full rounded-xl border border-gray-300 bg-gray-50 py-3 pl-11 pr-4
                    text-sm shadow-sm transition
                    focus:border-emerald-500
                    focus:ring-emerald-500
                    dark:bg-gray-700
                    dark:border-gray-600
                    dark:text-white">

            </div>

        </div>

        {{-- PASSWORD --}}

        <div x-data="{ show:false }">

            <label
                class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-300">

                Password

            </label>

            <div class="relative">

                <span
                    class="absolute left-4 top-3.5 text-gray-400">

                    <svg
                        class="w-5 h-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 15v2m-6 4h12a2
                            2 0 002-2v-6a2 2 0
                            00-2-2H6a2 2 0
                            00-2 2v6a2 2 0
                            002 2zm10-10V7a4 4 0
                            00-8 0v4h8z"/>

                    </svg>

                </span>

                <input

                    x-bind:type="show ? 'text' : 'password'"

                    id="password"

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

                <button

                    type="button"

                    @click="show=!show"

                    class="absolute right-4 top-3 text-gray-400 hover:text-emerald-600 transition">

                    <svg
                        x-show="!show"
                        class="w-5 h-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 12a3 3 0 11-6 0
                            3 3 0 016 0"/>

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M2.458 12C3.732
                            7.943 7.523 5 12 5
                            c4.478 0 8.268 2.943
                            9.542 7-1.274 4.057
                            -5.064 7-9.542 7
                            -4.477 0-8.268-2.943
                            -9.542-7z"/>

                    </svg>

                    <svg
                        x-show="show"
                        x-cloak
                        class="w-5 h-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M13.875
                            18.825A10.05 10.05
                            0 0112 19
                            c-4.478 0-8.268-2.943
                            -9.543-7a9.97
                            9.97 0 011.563-3.029
                            m5.858-5.908A8.98
                            8.98 0 0112
                            5c4.478
                            0 8.268
                            2.943
                            9.542
                            7a9.97
                            9.97
                            0
                            01-2.07
                            3.522M15
                            12a3
                            3
                            0
                            11-6
                            0
                            3
                            3
                            0
                            016
                            0m6
                            6L3
                            3"/>

                    </svg>

                </button>

            </div>

        </div>

        {{-- Remember --}}
        <div class="flex items-center justify-between">

            <label class="inline-flex items-center">

                <input

                    type="checkbox"

                    name="remember"

                    class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">

                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">

                    Ingat saya

                </span>

            </label>

            @if(Route::has('password.request'))

                <a

                    href="{{ route('password.request') }}"

                    class="text-sm font-medium text-emerald-600 hover:underline">

                    Lupa Password?

                </a>

            @endif

        </div>

        {{-- BUTTON --}}
        <button

            type="submit"

            class="group w-full rounded-xl bg-emerald-600 py-3 font-semibold text-white shadow-lg transition duration-300 hover:-translate-y-1 hover:bg-emerald-700">

            <span class="flex items-center justify-center gap-2">

                Masuk ke Dashboard

                <svg
                    class="w-5 h-5 transition group-hover:translate-x-1"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 5l7 7-7 7"/>

                </svg>

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