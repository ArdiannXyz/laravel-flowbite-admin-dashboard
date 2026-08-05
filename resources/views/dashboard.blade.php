@extends('layouts.dashboard')

@section('content')

<div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5">

    <div>

        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
            Dashboard Manajer Gudang
        </h1>

        <p class="mt-2 text-gray-500">
            Monitoring stok barang secara real-time.
        </p>

    </div>

    <div class="flex gap-2 mt-4 sm:mt-0">

        <a href="#"
           class="text-white bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg">

            + Barang Masuk

        </a>

        <a href="#"
           class="text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg">

            - Barang Keluar

        </a>

        <a href="#"
           class="text-white bg-purple-600 hover:bg-purple-700 px-4 py-2 rounded-lg">

            Stock Opname

        </a>

    </div>

</div>

@endsection