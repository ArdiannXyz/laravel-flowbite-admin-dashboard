@props(['icon' => null, 'routeName' => null, 'title' => null])
<li>
    <a href="{{ route($routeName) }}"
        class="flex items-center p-2 text-base text-gray-900 dark:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs($routeName) ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
        {{ $icon }}
        <span class="ml-3" sidebar-toggle-item> {{ $title }} </span>
    </a>
</li>