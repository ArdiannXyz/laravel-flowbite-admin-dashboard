<x-sidebar-dashboard>
    <x-sidebar-menu-dashboard routeName="dashboard-staff.index" title="Dashboard Staff Gudang"/>
    <x-sidebar-menu-dashboard routeName="report.index" title="Laporan"/>
    <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase dark:text-gray-400">
        MANAJEMEN GUDANG
    </div>
    <x-sidebar-menu-dashboard routeName="warehouse.dashboard" title="Dashboard Gudang"/>
    <x-sidebar-menu-dropdown-dashboard routeName="products.*" title="Manajemen Produk">
        <x-sidebar-menu-dropdown-item-dashboard routeName="products.index" title="Daftar Produk"/>
        <x-sidebar-menu-dropdown-item-dashboard routeName="products.create" title="Tambah Produk"/>
    </x-sidebar-menu-dropdown-dashboard>
    <x-sidebar-menu-dropdown-dashboard routeName="stock-in.*" title="Barang Masuk">
        <x-sidebar-menu-dropdown-item-dashboard routeName="stock-in.index" title="Riwayat Barang Masuk"/>
        <x-sidebar-menu-dropdown-item-dashboard routeName="stock-in.create" title="Penerimaan Barang"/>
    </x-sidebar-menu-dropdown-dashboard>
    <x-sidebar-menu-dropdown-dashboard routeName="stock-out.*" title="Barang Keluar">
        <x-sidebar-menu-dropdown-item-dashboard routeName="stock-out.index" title="Riwayat Barang Keluar"/>
        <x-sidebar-menu-dropdown-item-dashboard routeName="stock-out.create" title="Pengeluaran Barang"/>
    </x-sidebar-menu-dropdown-dashboard>
    <x-sidebar-menu-dropdown-dashboard routeName="stock-opname.*" title="Stock Opname">
        <x-sidebar-menu-dropdown-item-dashboard routeName="stock-opname.index" title="Riwayat Opname"/>
        <x-sidebar-menu-dropdown-item-dashboard routeName="stock-opname.create" title="Pemeriksaan Stok"/>
    </x-sidebar-menu-dropdown-dashboard>

    <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase dark:text-gray-400">
        ADMINISTRASI
    </div>
    <x-sidebar-menu-dashboard routeName="dashboard" title="Dashboard Admin"/>
    <x-sidebar-menu-dropdown-dashboard routeName="categories.*" title="Master Data">
        <x-sidebar-menu-dropdown-item-dashboard routeName="categories.index" title="Kategori"/>
    </x-sidebar-menu-dropdown-dashboard>
</x-sidebar-dashboard>