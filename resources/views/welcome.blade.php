<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stockify - Smart Inventory Management System</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="h-full bg-gray-900 text-gray-100 flex flex-col justify-between antialiased selection:bg-blue-500 selection:text-white">

    <!-- Background Decoration Glow -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-blue-600/20 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 -right-40 w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl"></div>
    </div>

    <!-- Header / Navbar -->
    <header class="relative z-10 max-w-7xl mx-auto w-full px-6 py-6 flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center font-bold text-xl shadow-lg shadow-blue-500/30">
                S
            </div>
            <span class="text-xl font-bold tracking-tight text-white">Stockify</span>
        </div>
        <div>
            @auth
                <a href="{{ url('/dashboard') }}" class="text-sm font-medium px-4 py-2 bg-gray-800 hover:bg-gray-700 border border-gray-700 rounded-lg transition-colors">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="text-sm font-medium px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-lg transition-colors shadow-sm shadow-blue-500/30">
                    Login
                </a>
            @endauth
        </div>
    </header>

    <!-- Main Content -->
    <main class="relative z-10 max-w-4xl mx-auto px-6 py-12 text-center flex-grow flex flex-col justify-center">
        <div class="inline-flex items-center space-x-2 px-3 py-1 bg-blue-500/10 border border-blue-500/20 text-blue-400 rounded-full text-xs font-semibold uppercase tracking-wider mb-6 mx-auto">
            <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
            <span>Segera Hadir</span>
        </div>

        <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight text-white mb-6 leading-tight">
            Manajemen Stok Gudang Lebih <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-400">Cepat & Terstruktur</span>
        </h1>

        <p class="text-lg sm:text-xl text-gray-400 mb-10 max-w-2xl mx-auto leading-relaxed">
            Stockify sedang dalam tahap pengembangan akhir untuk menghadirkan solusi kontrol inventaris, pencatatan barang masuk/keluar, dan laporan real-time yang handal.
        </p>

        <!-- Feature Pills -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 max-w-2xl mx-auto mb-12 text-left">
            <div class="p-4 bg-gray-800/50 border border-gray-800 rounded-xl">
                <div class="font-semibold text-white mb-1">Multi-Role Access</div>
                <div class="text-xs text-gray-400">Hak akses terisolasi untuk Admin, Manajer, dan Staff Gudang.</div>
            </div>
            <div class="p-4 bg-gray-800/50 border border-gray-800 rounded-xl">
                <div class="font-semibold text-white mb-1">Stock Opname</div>
                <div class="text-xs text-gray-400">Audit fisik inventaris secara berkala dengan mudah.</div>
            </div>
            <div class="p-4 bg-gray-800/50 border border-gray-800 rounded-xl">
                <div class="font-semibold text-white mb-1">Export Laporan</div>
                <div class="text-xs text-gray-400">Cetak laporan ringkas format PDF & Excel instan.</div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="relative z-10 max-w-7xl mx-auto w-full px-6 py-6 text-center text-xs text-gray-500 border-t border-gray-800/80">
        &copy; {{ date('Y') }} Stockify Inventory Core System. Seluruh hak cipta dilindungi.
    </footer>

</body>
</html>