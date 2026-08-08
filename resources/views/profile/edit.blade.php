@extends('layouts.dashboard')

@section('content')
<div class="px-4 pt-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Profil Saya</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">Kelola informasi akun, keamanan, dan preferensi kamu.</p>
    </div>

    <div class="space-y-6 max-w-3xl">
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            @include('profile.partials.update-password-form')
        </div>
    </div>
</div>
@endsection