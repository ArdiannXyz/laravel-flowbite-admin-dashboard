@extends('layouts.dashboard')

@section('content')

<div class="p-4">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
            Tambah Kategori
        </h1>

        <p class="text-gray-500 dark:text-gray-400 mt-1">
            Tambahkan kategori produk baru.
        </p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">

        <div class="p-6">

            <form method="POST" action="{{ route('categories.store') }}">

                @include('categories.form')

            </form>

        </div>

    </div>

</div>

@endsection