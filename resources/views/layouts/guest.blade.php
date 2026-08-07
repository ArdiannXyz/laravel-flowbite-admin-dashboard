<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ config('app.name', 'Stockify') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-950">

    <div class="min-h-screen grid lg:grid-cols-2">

        <!-- ================= LEFT ================= -->
        <div class="hidden lg:flex relative overflow-hidden bg-gradient-to-br from-emerald-600 via-emerald-700 to-teal-800">

            <!-- Blur Circle -->
            <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-white/10 blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 rounded-full bg-white/10 blur-3xl"></div>

            <div class="relative z-10 flex flex-col justify-center px-20 pt-6 lg:pt-8 xl:pt-10 pb-16 text-white w-full">

                <!-- Logo -->
                <div class="flex items-center gap-4">
                    <div class="h-16 w-16 shrink-0 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center shadow-lg">
                        <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7L12 3L4 7M20 7L12 11M20 7V17L12 21M12 11L4 7M12 11V21M4 7V17L12 21" />
                        </svg>
                    </div>
                    <div class="flex flex-col justify-center">
                        <h1 class="text-4xl font-bold leading-none">Stockify</h1>
                        <p class="mt-2 text-emerald-100 leading-none">Inventory Management System</p>
                    </div>
                </div>

                <h2 class="mt-6 text-5xl font-bold leading-tight">
                    Kelola Stok Barang
                    <br>
                    Menjadi Lebih Mudah.
                </h2>

                <p class="mt-6 text-lg text-emerald-100 leading-8 max-w-xl">
                    Stockify membantu perusahaan mengelola produk,
                    supplier, transaksi barang masuk,
                    barang keluar,
                    hingga laporan stok secara real-time.
                </p>

                <!-- Feature -->
                <div class="grid grid-cols-2 gap-5 mt-14">

                    <div class="rounded-2xl bg-white/10 backdrop-blur p-5">
                        <div class="text-3xl">📦</div>
                        <h3 class="mt-3 font-semibold">Produk</h3>
                        <p class="mt-2 text-sm text-emerald-100">Kelola seluruh produk dalam satu tempat.</p>
                    </div>

                    <div class="rounded-2xl bg-white/10 backdrop-blur p-5">
                        <div class="text-3xl">🚚</div>
                        <h3 class="mt-3 font-semibold">Supplier</h3>
                        <p class="mt-2 text-sm text-emerald-100">Data supplier tersimpan dengan aman.</p>
                    </div>

                    <div class="rounded-2xl bg-white/10 backdrop-blur p-5">
                        <div class="text-3xl">📊</div>
                        <h3 class="mt-3 font-semibold">Dashboard</h3>
                        <p class="mt-2 text-sm text-emerald-100">Statistik stok secara realtime.</p>
                    </div>

                    <div class="rounded-2xl bg-white/10 backdrop-blur p-5">
                        <div class="text-3xl">📑</div>
                        <h3 class="mt-3 font-semibold">Laporan</h3>
                        <p class="mt-2 text-sm text-emerald-100">Export PDF & Excel.</p>
                    </div>

                </div>
            </div>
        </div>

        <!-- ================= RIGHT ================= -->
        <div class="relative lg:sticky lg:top-0 lg:h-screen flex items-center justify-center p-6 bg-gradient-to-br from-gray-50 via-white to-gray-100 dark:from-gray-900 dark:via-gray-900 dark:to-black">

            <!-- Background Decoration -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-24 right-0 w-72 h-72 rounded-full bg-emerald-200/30 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-72 h-72 rounded-full bg-teal-200/20 blur-3xl"></div>
            </div>

            <div class="relative z-10 w-full max-w-md">
                @yield('content')
            </div>

        </div>

    </div>

</body>

</html>