@extends('layouts.dashboard')

@section('content')
<div class="px-4 pt-6">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Detail Supplier: {{ $supplier->name }}</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Informasi profil supplier dan daftar barang pasokan terkait.</p>
        </div>
        <div>
            <a href="{{ route('suppliers.index') }}" class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                ← Kembali ke Daftar Supplier
            </a>
        </div>
    </div>

    <!-- Supplier Overview Card -->
    <div class="mb-6 grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="flex items-center gap-3 mb-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $supplier->name }}</h2>
                    <span class="font-mono text-xs text-gray-500 dark:text-gray-400">Kode: {{ $supplier->code }}</span>
                </div>
            </div>

            <div class="space-y-3 text-sm border-t pt-4 dark:border-gray-700">
                <div class="flex justify-between border-b pb-2 dark:border-gray-700">
                    <span class="text-gray-500 dark:text-gray-400">Email:</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $supplier->email ?? '-' }}</span>
                </div>
                <div class="flex justify-between border-b pb-2 dark:border-gray-700">
                    <span class="text-gray-500 dark:text-gray-400">Telepon / Whatsapp:</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $supplier->phone ?? '-' }}</span>
                </div>
                <div class="border-b pb-2 dark:border-gray-700">
                    <span class="block text-gray-500 dark:text-gray-400 mb-1">Alamat Kantor / Gudang Supplier:</span>
                    <span class="font-medium text-gray-900 dark:text-white text-xs leading-relaxed">{{ $supplier->address ?? '-' }}</span>
                </div>
            </div>
        </div>

        <!-- Products Supplied by this Supplier -->
        <div class="lg:col-span-2 rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Daftar Produk yang Disuplai</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-4 py-3">Nama Produk</th>
                            <th class="px-4 py-3">SKU</th>
                            <th class="px-4 py-3">Kategori</th>
                            <th class="px-4 py-3">Harga Beli (AVG)</th>
                            <th class="px-4 py-3 text-center">Stok Fisik</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($supplier->products as $prod)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="px-4 py-3 font-semibold text-gray-900 dark:text-white">
                                    <a href="{{ route('products.show', $prod->id) }}" class="hover:underline hover:text-blue-600">
                                        {{ $prod->name }}
                                    </a>
                                </td>
                                <td class="px-4 py-3 font-mono text-xs text-gray-500">{{ $prod->sku }}</td>
                                <td class="px-4 py-3 text-xs">{{ $prod->category->name ?? '-' }}</td>
                                <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">Rp {{ number_format($prod->buy_price, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-center font-bold text-blue-600 dark:text-blue-400">
                                    {{ $prod->current_stock }} {{ $prod->unit }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-gray-500 dark:text-gray-400">Belum ada produk terdaftar untuk supplier ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
