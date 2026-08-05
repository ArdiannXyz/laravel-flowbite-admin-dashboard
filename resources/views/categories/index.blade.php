@extends('layouts.dashboard')

@section('content')
<div class="p-4">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
            Manajemen Kategori
        </h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">
            Kelola seluruh kategori produk.
        </p>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 text-green-800 rounded-lg bg-green-50 border border-green-200 dark:bg-green-900 dark:text-green-300 dark:border-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 p-6 border-b dark:border-gray-700">

            <form method="GET" class="flex gap-2">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari kategori..."
                    class="w-64 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm">

                <button
                    type="submit"
                    class="px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800">
                    Cari
                </button>
            </form>

            <a href="{{ route('categories.create') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                + Tambah Kategori
            </a>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">

                <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                    <tr>
                        <th class="px-6 py-3">Nama</th>
                        <th class="px-6 py-3">Deskripsi</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($categories as $category)

                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">

                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ $category->name }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $category->description ?? '-' }}
                            </td>

                            <td class="px-6 py-4">

                                <div class="flex justify-center gap-3">

                                    <a href="{{ route('categories.edit',$category->id) }}"
                                        class="text-blue-600 hover:underline">
                                        Edit
                                    </a>

                                    <form action="{{ route('categories.destroy',$category->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="text-red-600 hover:underline">
                                            Hapus
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="3"
                                class="text-center py-8 text-gray-500 dark:text-gray-400">

                                Belum ada data kategori.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="p-6">
            {{ $categories->links() }}
        </div>

    </div>

</div>
@endsection