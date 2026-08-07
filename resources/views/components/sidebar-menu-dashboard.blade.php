@props(['icon' => null, 'routeName' => null, 'title' => null, 'activeRoute' => null])
<li>
    <a href="{{ route($routeName) }}"
        class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 group transition-colors {{ request()->routeIs($activeRoute ?? $routeName) ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300 font-semibold' : '' }}">
        @if(isset($icon) && (is_string($icon) ? trim($icon) !== '' : $icon->isNotEmpty()))
            {{ $icon }}
        @else
            <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 dark:text-gray-500 dark:group-hover:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/></svg>
        @endif
        <span class="ml-3 truncate"> {{ $title }} </span>
    </a>
</li>