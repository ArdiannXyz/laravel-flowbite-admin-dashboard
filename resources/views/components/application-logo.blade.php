<a href="{{ url('/') }}" class="flex ml-2 md:mr-6">
    @if($settings['app_logo'] ?? null)
        <img src="{{ Storage::url($settings['app_logo']) }}" class="h-8 mr-3" alt="{{ $settings['app_name'] ?? 'Stockify' }} Logo" />
    @else
        <img src="{{ asset('static/images/logo.svg') }}" class="h-8 mr-3" alt="Stockify Logo" />
    @endif
    <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap text-gray-900 dark:text-white">
        {{ $settings['app_name'] ?? 'Stockify' }}
    </span>
</a>