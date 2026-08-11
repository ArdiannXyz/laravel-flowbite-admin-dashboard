<section>
    <header class="mb-4">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
            {{ __('Informasi Profil') }}
        </h2>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            {{ __('Perbarui nama dan alamat email akun kamu.') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-4">
    @csrf
    @method('patch')

    <!-- Foto Profil -->
    <div>
        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Foto Profil</label>
        <div class="flex items-center gap-4">
            <img class="h-16 w-16 rounded-full object-cover border-2 border-primary-500"
                 src="{{ $user->profile_photo_path ? Storage::url($user->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random' }}"
                 alt="Foto profil {{ $user->name }}">
            <div class="flex-1">
                <input type="file" name="profile_photo" id="profile_photo" accept="image/*"
                    class="w-full rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Format: JPG, PNG (Maksimal 2MB).</p>
                @error('profile_photo')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <div>
        <label for="name" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Nama</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
                class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
            @error('name')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
                class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
            @error('email')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 rounded-lg bg-yellow-50 p-3 text-sm text-yellow-800 dark:bg-gray-700 dark:text-yellow-300">
                    {{ __('Alamat email kamu belum diverifikasi.') }}
                    <button form="send-verification" class="ml-1 underline font-medium hover:text-yellow-900 dark:hover:text-yellow-200">
                        {{ __('Kirim ulang email verifikasi.') }}
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-green-600 dark:text-green-400">
                            {{ __('Link verifikasi baru telah dikirim ke email kamu.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                {{ __('Simpan') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 dark:text-green-400">{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>