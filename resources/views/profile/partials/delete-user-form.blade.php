<section class="space-y-4">
    <header>
        <h2 class="text-lg font-semibold text-red-700 dark:text-red-400">
            {{ __('Hapus Akun') }}
        </h2>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            {{ __('Setelah akun dihapus, seluruh data terkait akan dihapus secara permanen. Unduh data yang ingin kamu simpan sebelum melanjutkan.') }}
        </p>
    </header>

    <form method="post"
          action="{{ route('profile.destroy') }}"
          data-confirm-delete="Akun beserta seluruh datanya akan dihapus permanen. Masukkan password terlebih dahulu jika diperlukan."
          data-confirm-title="Hapus Akun Ini?"
          class="space-y-4">
        @csrf
        @method('delete')

        <div class="max-w-sm">
            <label for="password" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                {{ __('Konfirmasi Password') }}
            </label>
            <input id="password" name="password" type="password" placeholder="{{ __('Masukkan password kamu') }}"
                class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-red-500 focus:ring-red-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
            @error('password', 'userDeletion')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
            class="rounded-lg bg-red-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
            {{ __('Hapus Akun') }}
        </button>
    </form>
</section>