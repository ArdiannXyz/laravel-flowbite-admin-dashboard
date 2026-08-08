<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stockify - Smart Inventory Management System</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gradient-to-b from-gray-50 via-white to-gray-100">

    <!-- Header / Navbar -->
    <header class="relative z-10 max-w-6xl mx-auto w-full px-6 py-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="h-10 w-10 rounded-xl bg-emerald-600 flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 7L12 3L4 7M20 7L12 11M20 7V17L12 21M12 11L4 7M12 11V21M4 7V17L12 21" />
                </svg>
            </div>
            <span class="text-xl font-bold tracking-tight text-gray-900">Stockify</span>
        </div>

        <div>
            @auth
                <a href="{{ url('/dashboard') }}"
                    class="text-sm font-semibold px-5 py-2.5 rounded-xl bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 transition shadow-sm">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}"
                    class="text-sm font-semibold px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white transition shadow-lg shadow-emerald-600/20 hover:-translate-y-0.5 duration-300">
                    Login
                </a>
            @endauth
        </div>
    </header>

    <!-- Hero -->
    <main class="relative overflow-hidden">

        <div class="relative bg-gradient-to-br from-emerald-600 via-emerald-700 to-teal-800 mx-4 sm:mx-6 rounded-3xl shadow-2xl">

            <!-- Blur Circle Decoration -->
            <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-white/10 blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 rounded-full bg-white/10 blur-3xl pointer-events-none"></div>

            <div class="relative z-10 max-w-4xl mx-auto px-6 py-20 sm:py-28 text-center text-white">

                
                <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight mb-6 leading-tight">
                    Manajemen Stok Gudang Lebih
                    <span class="text-emerald-200">Cepat & Terstruktur</span>
                </h1>

                <p class="text-lg sm:text-xl text-emerald-100 mb-10 max-w-2xl mx-auto leading-relaxed">
                    Stockify sedang dalam tahap pengembangan akhir untuk menghadirkan solusi kontrol inventaris,
                    pencatatan barang masuk/keluar, dan laporan real-time yang handal.
                </p>

                <a href="{{ route('login') }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-white text-emerald-700 px-6 py-3 font-semibold shadow-lg transition duration-300 hover:-translate-y-1 hover:bg-emerald-50">
                    Masuk ke Dashboard
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Feature Cards -->
        <div class="max-w-5xl mx-auto px-6 -mt-10 relative z-10">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">

                <div class="bg-white/80 backdrop-blur-xl border border-gray-200 rounded-3xl shadow-xl p-6 text-left">
                    <div class="text-3xl">🔐</div>
                    <h3 class="mt-3 font-semibold text-gray-900">Multi-Role Access</h3>
                    <p class="mt-2 text-sm text-gray-500">
                        Hak akses terisolasi untuk Admin, Manajer, dan Staff Gudang.
                    </p>
                </div>

                <div class="bg-white/80 backdrop-blur-xl border border-gray-200 rounded-3xl shadow-xl p-6 text-left">
                    <div class="text-3xl">📋</div>
                    <h3 class="mt-3 font-semibold text-gray-900">Stock Opname</h3>
                    <p class="mt-2 text-sm text-gray-500">
                        Audit fisik inventaris secara berkala dengan mudah.
                    </p>
                </div>

                <div class="bg-white/80 backdrop-blur-xl border border-gray-200 rounded-3xl shadow-xl p-6 text-left">
                    <div class="text-3xl">📑</div>
                    <h3 class="mt-3 font-semibold text-gray-900">Export Laporan</h3>
                    <p class="mt-2 text-sm text-gray-500">
                        Cetak laporan ringkas format PDF & Excel instan.
                    </p>
                </div>

            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="relative z-10 max-w-6xl mx-auto w-full px-6 py-10 mt-16 text-center text-xs text-gray-400 border-t border-gray-200">
        &copy; {{ date('Y') }} Stockify &bull; Inventory Management System. Seluruh hak cipta dilindungi.
    </footer>

</body>

</html>