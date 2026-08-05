<x-sidebar-dashboard>

    <x-sidebar-menu-dashboard
        routeName="dashboard"
        title="Dashboard Admin"/>

    <x-sidebar-menu-dropdown-dashboard
        routeName="categories.*"
        title="Master Data">

        <x-sidebar-menu-dropdown-item-dashboard
            routeName="categories.index"
            title="Kategori"/>

    </x-sidebar-menu-dropdown-dashboard>

</x-sidebar-dashboard>