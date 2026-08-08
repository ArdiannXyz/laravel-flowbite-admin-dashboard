@extends('layouts.dashboard')

@section('content')
<div class="px-4 pt-6">
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Daftar Supplier (Pemasok)</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Informasi relasi vendor dan supplier pengadaan barang gudang.</p>
        </div>
        @role('admin')
            <div>
                <a href="{{ route('suppliers.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-blue-700 px-4 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Supplier Baru
                </a>
            </div>
        @endrole
    </div>

    <!-- Alert Flash Messages -->
    @if(session('success'))
        <div class="mb-4 rounded-lg bg-green-50 p-4 text-sm text-green-800 dark:bg-gray-800 dark:text-green-400" role="alert">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 rounded-lg bg-red-50 p-4 text-sm text-red-800 dark:bg-gray-800 dark:text-red-400" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <!-- Filter & Search Bar -->
    <div class="mb-4 rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <form method="GET" action="{{ route('suppliers.index') }}" class="flex flex-col gap-4 md:flex-row md:items-center">
            <div class="flex-1">
                <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Cari nama supplier, kode, email, atau telepon..." class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400">
            </div>
            <div class="flex items-center gap-2">
                <button type="submit" class="rounded-lg bg-gray-800 px-4 py-2.5 text-sm font-medium text-white hover:bg-gray-900 dark:bg-gray-700 dark:hover:bg-gray-600">
                    Filter
                </button>
                <a href="{{ route('suppliers.index') }}" class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Suppliers Table -->
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-3">Kode</th>
                        <th class="px-6 py-3">Nama Supplier</th>
                        <th class="px-6 py-3">Kontak Info</th>
                        <th class="px-6 py-3">Alamat</th>
                        <th class="px-6 py-3 text-center">Produk Terkait</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($suppliers as $sup)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4 font-mono text-xs font-semibold text-gray-900 dark:text-white">
                                <span class="rounded bg-gray-100 px-2 py-1 dark:bg-gray-700">{{ $sup->code }}</span>
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                <a href="{{ route('suppliers.show', $sup->id) }}" class="hover:underline hover:text-blue-600 dark:hover:text-blue-400">
                                    {{ $sup->name }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-xs">
                                <div><span class="font-medium text-gray-700 dark:text-gray-300">Email:</span> {{ $sup->email ?? '-' }}</div>
                                <div class="mt-0.5"><span class="font-medium text-gray-700 dark:text-gray-300">Telp:</span> {{ $sup->phone ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 text-xs max-w-xs truncate" title="{{ $sup->address }}">
                                {{ $sup->address ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-bold text-blue-800 dark:bg-blue-900/40 dark:text-blue-300">
                                    {{ $sup->products_count ?? 0 }} Produk
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('suppliers.show', $sup->id) }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white" title="Detail">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    @role('admin')
                                        <a href="{{ route('suppliers.edit', $sup->id) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400" title="Edit Supplier">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        <form action="{{ route('suppliers.destroy', $sup->id) }}" method="POST" data-confirm-delete="Apakah Anda yakin ingin menghapus supplier '{{ $sup->name }}'?" data-confirm-title="Hapus Supplier" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400" title="Hapus Supplier">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    @endrole
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-gray-500 dark:text-gray-400">Tidak ada data supplier ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-gray-200 p-4 dark:border-gray-700">
            {{ $suppliers->links() }}
        </div>
    </div>
</div>
@endsection
