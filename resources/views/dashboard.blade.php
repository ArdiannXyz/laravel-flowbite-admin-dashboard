@extends('layouts.dashboard')

@section('content')

<!-- Header Dashboard Admin -->
<div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl dark:text-white">
            Dashboard Utama (Admin)
        </h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Ringkasan performa sistem inventaris, transaksi stok, grafik ketersediaan, dan aktivitas pengguna.
        </p>
    </div>

    <!-- Quick Actions Khusus Admin -->
    <div class="flex flex-wrap gap-2 mt-4 sm:mt-0">
        <a href="{{ route('products.create') }}"
           class="inline-flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Produk
        </a>
    </div>
</div>

<div class="px-4 pt-6">

    <!-- 1. STATISTIC CARDS -->
    <div class="grid w-full grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4 mb-6">
        
        <!-- Total Produk -->
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6 dark:border-gray-700 dark:bg-gray-800">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Produk</h3>
                    <span class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">
                        {{ number_format($totalProducts ?? 0) }}
                    </span>
                </div>
                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-xl flex items-center justify-center text-blue-600 dark:text-blue-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
            </div>
            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Terdaftar dalam Master Data</p>
        </div>

        <!-- Total Barang Masuk -->
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6 dark:border-gray-700 dark:bg-gray-800">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Barang Masuk</h3>
                    <span class="text-2xl font-bold leading-none text-green-600 sm:text-3xl dark:text-green-400">
                        +{{ number_format($totalStockIn ?? 0) }}
                    </span>
                </div>
                <div class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-xl flex items-center justify-center text-green-600 dark:text-green-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path></svg>
                </div>
            </div>
            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Total akumulasi penerimaan</p>
        </div>

        <!-- Total Barang Keluar -->
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6 dark:border-gray-700 dark:bg-gray-800">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Barang Keluar</h3>
                    <span class="text-2xl font-bold leading-none text-red-600 sm:text-3xl dark:text-red-400">
                        -{{ number_format($totalStockOut ?? 0) }}
                    </span>
                </div>
                <div class="w-10 h-10 bg-red-100 dark:bg-red-900 rounded-xl flex items-center justify-center text-red-600 dark:text-red-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path></svg>
                </div>
            </div>
            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Total akumulasi pengeluaran</p>
        </div>

        <!-- Stok Peringatan Kritis -->
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6 dark:border-gray-700 dark:bg-gray-800">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Stok Kritis</h3>
                    <span class="text-2xl font-bold leading-none text-red-600 sm:text-3xl dark:text-red-400">
                        {{ count($lowStockProducts ?? []) }}
                    </span>
                </div>
                <div class="w-10 h-10 bg-red-100 dark:bg-red-900 rounded-xl flex items-center justify-center text-red-600 dark:text-red-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
            </div>
            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Mencapai batas minimum stok</p>
        </div>
    </div>

    <!-- 2. GRAFIK STOK BARANG PER KATEGORI -->
    <div class="mb-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <div class="mb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    Grafik Distribusi Stok per Kategori
                </h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">Visualisasi interaktif jumlah fisik stok barang berdasarkan kategori produk.</p>
            </div>
            <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700 dark:bg-blue-900/40 dark:text-blue-300">
                <span class="h-2 w-2 rounded-full bg-blue-600 animate-pulse"></span>
                Real-time Data
            </span>
        </div>

        <!-- Interactive ApexChart -->
        <div id="categoryStockChart" class="w-full min-h-[300px]"></div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const chartData = @json($categoryChartData ?? []);
    if (!chartData || chartData.length === 0) return;

    const categories = chartData.map(item => item.name);
    const stocks = chartData.map(item => item.stock);
    const palette = ['#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#ec4899', '#06b6d4', '#6366f1'];

    function getOptions() {
        const isDark = document.documentElement.classList.contains('dark');
        const labelColor = isDark ? '#ffffff' : '#1f2937';
        const axisColor = isDark ? '#9ca3af' : '#4b5563';

        return {
            series: [{
                name: 'Jumlah Stok',
                data: stocks
            }],
            chart: {
                type: 'bar',
                height: 320,
                toolbar: { show: false },
                fontFamily: 'Inter, sans-serif',
                background: 'transparent',
                foreColor: labelColor
            },
            plotOptions: {
                bar: {
                    borderRadius: 6,
                    horizontal: true,
                    barHeight: '55%',
                    distributed: true
                }
            },
            colors: palette,
            dataLabels: {
                enabled: true,
                formatter: function (val) {
                    return val.toLocaleString('id-ID') + " Unit";
                },
                style: {
                    fontSize: '12px',
                    fontWeight: 700,
                    colors: ['#ffffff']
                },
                dropShadow: {
                    enabled: true,
                    top: 1,
                    left: 1,
                    blur: 1,
                    color: '#000',
                    opacity: 0.5
                }
            },
            xaxis: {
                categories: categories,
                labels: {
                    style: {
                        colors: categories.map(() => axisColor),
                        fontFamily: 'Inter, sans-serif'
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: categories.map(() => labelColor),
                        fontSize: '13px',
                        fontWeight: 700,
                        fontFamily: 'Inter, sans-serif'
                    }
                }
            },
            legend: { show: false },
            grid: {
                borderColor: isDark ? '#374151' : '#e5e7eb',
                strokeDashArray: 4
            },
            tooltip: {
                theme: isDark ? 'dark' : 'light',
                y: {
                    formatter: function (val) {
                        return val.toLocaleString('id-ID') + " Unit Stok";
                    }
                }
            }
        };
    }

    const chartEl = document.querySelector("#categoryStockChart");
    if (chartEl && typeof ApexCharts !== 'undefined') {
        let chart = new ApexCharts(chartEl, getOptions());
        chart.render();

        // Dynamic update on theme toggle
        const observer = new MutationObserver(function (mutations) {
            mutations.forEach(function (mutation) {
                if (mutation.attributeName === 'class') {
                    chart.updateOptions(getOptions());
                }
            });
        });
        observer.observe(document.documentElement, { attributes: true });
    }
});
</script>

    <!-- 3. GRID KONTEN UTAMA: AKTIVITAS & PERINGATAN STOK -->
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3 mb-6">
        
        <!-- Tabel Transaksi & Aktivitas Pengguna Terbaru (2 Kolom) -->
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800 xl:col-span-2">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Aktivitas Pengguna Terbaru</h3>
                <a href="{{ route('report.index') }}" class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-500">
                    Lihat Laporan Aktivitas
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">Produk</th>
                            <th scope="col" class="px-4 py-3">Tipe</th>
                            <th scope="col" class="px-4 py-3">Jumlah</th>
                            <th scope="col" class="px-4 py-3">Petugas</th>
                            <th scope="col" class="px-4 py-3">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($recentTransactions ?? [] as $transaction)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $transaction->product->name ?? '-' }}
                                </td>
                                <td class="px-4 py-3">
                                    @if(($transaction->type ?? '') === 'in')
                                        <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Masuk</span>
                                    @else
                                        <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Keluar</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 font-semibold text-gray-900 dark:text-white">
                                    {{ $transaction->quantity }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ $transaction->user->name ?? 'System' }}
                                </td>
                                <td class="px-4 py-3 text-xs whitespace-nowrap">
                                    {{ $transaction->created_at ? $transaction->created_at->diffForHumans() : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                    Belum ada transaksi stok tercatat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Sidebar Ringkas: Produk Kritis (1 Kolom) -->
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <h3 class="mb-4 text-lg font-bold text-gray-900 dark:text-white">Perlu Restock Segera</h3>
            <div class="space-y-3">
                @forelse ($lowStockProducts ?? [] as $product)
                    <div class="flex items-center justify-between p-3 bg-red-50 border border-red-100 rounded-lg dark:bg-red-900/20 dark:border-red-900/30">
                        <div>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $product->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Min. Stok: {{ $product->min_stock }}</p>
                        </div>
                        <div class="text-right">
                            <span class="text-sm font-bold text-red-600 dark:text-red-400">{{ $product->current_stock }} Item</span>
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-center text-sm text-gray-500 dark:text-gray-400">
                        Semua stok produk berada di batas aman.
                    </div>
                @endforelse
            </div>
        </div>

        </div>

</div>

@endsection