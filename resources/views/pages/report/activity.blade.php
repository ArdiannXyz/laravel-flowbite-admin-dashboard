@extends('layouts.dashboard')

@section('content')
<div class="p-4">

    {{-- HEADER --}}
    <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Laporan Aktivitas Pengguna</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Audit log & rekam jejak aktivitas operasional pengguna dalam sistem gudang.</p>
        </div>
    </div>

    {{-- FILTER & EXPORT --}}
    <div class="mb-6 rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <form method="GET" action="{{ route('report.activity') }}" class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                <div>
                    <label class="mb-1 block text-xs font-medium text-gray-700 dark:text-gray-300">Filter Pengguna</label>
                    <select name="user_id" onchange="this.form.submit()" class="block w-full min-w-[200px] rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <option value="">Semua Pengguna</option>
                        @foreach($users as $usr)
                            <option value="{{ $usr->id }}" {{ request('user_id') == $usr->id ? 'selected' : '' }}>
                                {{ $usr->name }} ({{ ucfirst($usr->role) }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-1 block text-xs font-medium text-gray-700 dark:text-gray-300">Dari Tanggal</label>
                    <input type="date" name="act_from_date" value="{{ request('act_from_date') }}" onchange="this.form.submit()" class="rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                </div>
                <div>
                    <label class="mb-1 block text-xs font-medium text-gray-700 dark:text-gray-300">Sampai Tanggal</label>
                    <input type="date" name="act_to_date" value="{{ request('act_to_date') }}" onchange="this.form.submit()" class="rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('report.export.aktivitas', request()->only(['user_id', 'act_from_date', 'act_to_date'])) }}" class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition-all hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Export PDF
                </a>
                <a href="{{ route('report.export.aktivitas-excel', request()->only(['user_id', 'act_from_date', 'act_to_date'])) }}" class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition-all hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-300">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Export Excel
                </a>
            </div>
        </form>
    </div>

    {{-- TABEL AKTIVITAS PENGGUNA --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-3">Waktu & Tanggal</th>
                        <th class="px-6 py-3">Nama Pengguna</th>
                        <th class="px-6 py-3">Peran (Role)</th>
                        <th class="px-6 py-3">Tipe Transaksi</th>
                        <th class="px-6 py-3">Rincian Aktivitas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($userActivities as $log)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4 text-xs font-mono text-gray-600 dark:text-gray-300 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($log->created_at)->translatedFormat('d M Y, H:i:s') }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white whitespace-nowrap">
                                {{ $log->user->name ?? 'System' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-bold text-gray-800 capitalize dark:bg-gray-700 dark:text-gray-300">
                                    {{ $log->user->role ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($log->type === 'in')
                                    <span class="rounded bg-blue-100 px-2.5 py-0.5 text-xs font-bold text-blue-800 dark:bg-blue-900/40 dark:text-blue-300">Barang Masuk</span>
                                @else
                                    <span class="rounded bg-purple-100 px-2.5 py-0.5 text-xs font-bold text-purple-800 dark:bg-purple-900/40 dark:text-purple-300">Barang Keluar</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-800 dark:text-gray-200">
                                Mencatat {{ $log->type === 'in' ? 'penerimaan' : 'pengeluaran' }} produk <strong>{{ $log->product->name ?? 'Barang' }}</strong> sejumlah <strong>{{ $log->quantity }} unit</strong>.
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-500 dark:text-gray-400">Tidak ada riwayat aktivitas pengguna ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-gray-200 p-4 dark:border-gray-700">
            {{ $userActivities->links() }}
        </div>
    </div>
</div>
@endsection
