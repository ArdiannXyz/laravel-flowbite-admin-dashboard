<x-guest-layout>
    <!-- Logo & Header Stockify -->
    <div class="mb-6 text-center">
        <!-- Logo Icon: Kotak/Box (representasi stok barang) -->
        <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-600 shadow-md shadow-indigo-200 dark:shadow-none">
            <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M20.25 7.5l-8.25-4.5L3.75 7.5m16.5 0l-8.25 4.5m8.25-4.5v9l-8.25 4.5m0-9L3.75 7.5m8.25 4.5v9M3.75 7.5v9l8.25 4.5" />
            </svg>
        </div>

        <h2 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">
            Stockify
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
            Kelola stok barang Anda dengan mudah. Silakan masuk untuk melanjutkan.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Alamat Email')" class="font-medium text-gray-700 dark:text-gray-300 mb-1" />
            <div class="relative rounded-lg shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 11-8 0 4 4 0 018 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <x-text-input id="email"
                    class="block w-full pl-10 pr-3 py-2.5 rounded-xl border-gray-300 dark:border-gray-700 focus:border-indigo-500 focus:ring-indigo-500 text-sm transition duration-150 ease-in-out"
                    type="email"
                    name="email"
                    :value="old('email')"
                    placeholder="nama@stockify.com"
                    required
                    autofocus
                    autocomplete="username" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <!-- Password dengan Fitur Toggle Show/Hide -->
        <div x-data="{ showPassword: false }">
            <x-input-label for="password" :value="__('Kata Sandi')" class="font-medium text-gray-700 dark:text-gray-300 mb-1" />
            <div class="relative rounded-lg shadow-sm">
                <!-- Ikon Gembok Kiri -->
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>

                <!-- Input Password Dynamic Type -->
                <x-text-input id="password"
                    class="block w-full pl-10 pr-10 py-2.5 rounded-xl border-gray-300 dark:border-gray-700 focus:border-indigo-500 focus:ring-indigo-500 text-sm transition duration-150 ease-in-out"
                    ::type="showPassword ? 'text' : 'password'"
                    name="password"
                    placeholder="••••••••"
                    required
                    autocomplete="current-password" />

                <!-- Tombol Toggle Mata -->
                <button type="button"
                    @click="showPassword = !showPassword"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 focus:outline-none"
                    tabindex="-1">

                    <!-- Ikon Mata Terbuka (Muncul saat password terlihat) -->
                    <svg x-show="showPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-cloak>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>

                    <!-- Ikon Mata Tertutup/Coret (Muncul saat password tersembunyi) -->
                    <svg x-show="!showPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a8.98 8.98 0 013.122-.563c4.478 0 8.268 2.943 9.542 7a9.97 9.97 0 01-2.07 3.522M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 6L3 3" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between text-sm">
            <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                <input id="remember_me"
                    type="checkbox"
                    class="rounded border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 focus:ring-offset-2 transition duration-150 cursor-pointer"
                    name="remember">
                <span class="ms-2 text-gray-600 dark:text-gray-400">{{ __('Ingat saya') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-xs font-semibold text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300 transition duration-150" href="{{ route('password.request') }}">
                    {{ __('Lupa password?') }}
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <x-primary-button class="w-full justify-center py-3 text-sm font-semibold rounded-xl bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 shadow-md hover:shadow-lg transition duration-200 transform active:scale-[0.99]">
                {{ __('Masuk ke Stockify') }}
            </x-primary-button>
        </div>

        <!-- Footer kecil -->
        <p class="text-center text-xs text-gray-400 dark:text-gray-500 pt-2">
            © {{ date('Y') }} Stockify — Sistem Manajemen Stok Barang
        </p>
    </form>
</x-guest-layout>