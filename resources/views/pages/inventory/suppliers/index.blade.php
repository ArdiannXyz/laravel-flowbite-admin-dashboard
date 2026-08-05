@extends('layouts.dashboard')

@section('content')
<div class="px-4 pt-6">
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Daftar Supplier</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Daftar seluruh supplier dan mitra penyedia barang gudang.</p>
        </div>
    </div>

    <!-- Alert Flash -->
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
                    Cari
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
                        <th class="px-6 py-3">Nama Supplier</th>
                        <th class="px-6 py-3">Kode</th>
                        <th class="px-6 py-3">Email</th>
                        <th class="px-6 py-3">Telepon</th>
                        <th class="px-6 py-3">Alamat</th>
                        <th class="px-6 py-3 text-center">Jumlah Produk</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($suppliers as $supplier)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                {{ $supplier->name }}
                            </td>
                            <td class="px-6 py-4 font-mono text-xs text-gray-600 dark:text-gray-300">
                                <span class="rounded-md bg-gray-100 px-2 py-1 font-semibold dark:bg-gray-700">
                                    {{ $supplier->code }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                {{ $supplier->email ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $supplier->phone ?? '-' }}
                            </td>
                            <td class="px-6 py-4 max-w-xs truncate" title="{{ $supplier->address }}">
                                {{ $supplier->address ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900/40 dark:text-blue-300">
                                    {{ $supplier->products_count ?? 0 }} Produk
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                Belum ada data supplier yang terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($suppliers->hasPages())
            <div class="border-t border-gray-200 p-4 dark:border-gray-700">
                {{ $suppliers->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
