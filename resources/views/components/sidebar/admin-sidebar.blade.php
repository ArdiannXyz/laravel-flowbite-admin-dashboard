<x-sidebar-dashboard>
    <x-sidebar-menu-dashboard routeName="dashboard-staff.index" title="Dashboard Staff Gudang"/>
    <x-sidebar-menu-dashboard routeName="laporan.index" title="Laporan"/>
    <x-sidebar-menu-dropdown-dashboard routeName="practice.*" title="Judul Dropdown">
        <x-sidebar-menu-dropdown-item-dashboard routeName="practice.first" title="Judul Item1"/>
        <x-sidebar-menu-dropdown-item-dashboard routeName="practice.second" title="Judul Item2"/>
    </x-sidebar-menu-dropdown-dashboard>
</x-sidebar-dashboard>