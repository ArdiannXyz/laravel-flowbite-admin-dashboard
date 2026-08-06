<x-sidebar-dashboard>
    {{-- ========================================== --}}
    {{-- 1. DASHBOARD BERDASARKAN ROLE             --}}
    {{-- ========================================== --}}
    @role('admin')
        <x-sidebar-menu-dashboard routeName="dashboard" title="Dashboard Admin"/>
    @endrole

    @role('manajer')
        <x-sidebar-menu-dashboard routeName="warehouse.dashboard" title="Dashboard Manajer"/>
    @endrole

    @role('staff')
        <x-sidebar-menu-dashboard routeName="dashboard-staff.index" title="Dashboard Staff"/>
    @endrole


    {{-- ========================================== --}}
    {{-- 2. MANAJEMEN PRODUK & KATEGORI             --}}
    {{-- ========================================== --}}
    @hasanyrole('admin|manajer')
        <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase dark:text-gray-400">
            MANAJEMEN PRODUK
        </div>

        <x-sidebar-menu-dropdown-dashboard routeName="products.*" title="Produk">
            <x-sidebar-menu-dropdown-item-dashboard routeName="products.index" title="Daftar Produk"/>
            @role('admin')
                <x-sidebar-menu-dropdown-item-dashboard routeName="products.create" title="Tambah Produk"/>
                <x-sidebar-menu-dropdown-item-dashboard routeName="categories.index" title="Kategori Produk"/>
                <x-sidebar-menu-dropdown-item-dashboard routeName="attributes.index" title="Atribut Produk"/>
                <x-sidebar-menu-dropdown-item-dashboard routeName="products.import" title="Import Produk"/>
                <x-sidebar-menu-dropdown-item-dashboard routeName="products.export" title="Export Produk"/>
            @endrole
        </x-sidebar-menu-dropdown-dashboard>
    @endhasanyrole


    {{-- ========================================== --}}
    {{-- 3. MANAJEMEN STOK & TRANSAKSI              --}}
    {{-- ========================================== --}}
    <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase dark:text-gray-400">
        MANAJEMEN STOK
    </div>

    {{-- Barang Masuk --}}
    <x-sidebar-menu-dropdown-dashboard routeName="stock-in.*" title="Barang Masuk">
        <x-sidebar-menu-dropdown-item-dashboard routeName="stock-in.index" title="Riwayat Barang Masuk"/>
        @hasanyrole('admin|manajer')
            <x-sidebar-menu-dropdown-item-dashboard routeName="stock-in.create" title="Catat Barang Masuk"/>
        @endhasanyrole
    </x-sidebar-menu-dropdown-dashboard>

    {{-- Barang Keluar --}}
    <x-sidebar-menu-dropdown-dashboard routeName="stock-out.*" title="Barang Keluar">
        <x-sidebar-menu-dropdown-item-dashboard routeName="stock-out.index" title="Riwayat Barang Keluar"/>
        @hasanyrole('admin|manajer')
            <x-sidebar-menu-dropdown-item-dashboard routeName="stock-out.create" title="Catat Barang Keluar"/>
        @endhasanyrole
    </x-sidebar-menu-dropdown-dashboard>

    {{-- Stock Opname --}}
    @hasanyrole('admin|manajer')
        <x-sidebar-menu-dropdown-dashboard routeName="stock-opname.*" title="Stock Opname">
            <x-sidebar-menu-dropdown-item-dashboard routeName="stock-opname.index" title="Riwayat Opname"/>
            <x-sidebar-menu-dropdown-item-dashboard routeName="stock-opname.create" title="Pemeriksaan Stok"/>
        </x-sidebar-menu-dropdown-dashboard>
    @endhasanyrole


    {{-- ========================================== --}}
    {{-- 4. SUPPLIER                                --}}
    {{-- ========================================== --}}
    @hasanyrole('admin|manajer')
        <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase dark:text-gray-400">
            MANAJEMEN SUPPLIER
        </div>
        @role('admin')
            <x-sidebar-menu-dropdown-dashboard routeName="suppliers.*" title="Supplier">
                <x-sidebar-menu-dropdown-item-dashboard routeName="suppliers.index" title="Daftar Supplier"/>
                <x-sidebar-menu-dropdown-item-dashboard routeName="suppliers.create" title="Tambah Supplier"/>
            </x-sidebar-menu-dropdown-dashboard>
        @else
            <x-sidebar-menu-dashboard routeName="suppliers.index" activeRoute="suppliers.*" title="Daftar Supplier"/>
        @endrole
    @endhasanyrole


    {{-- ========================================== --}}
    {{-- 5. LAPORAN                                 --}}
    {{-- ========================================== --}}
    @hasanyrole('admin|manajer')
        <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase dark:text-gray-400">
            LAPORAN
        </div>

        <x-sidebar-menu-dropdown-dashboard routeName="report.*" title="Pusat Laporan">
            <x-sidebar-menu-dropdown-item-dashboard routeName="report.stock" title="Laporan Stok Barang"/>
            <x-sidebar-menu-dropdown-item-dashboard routeName="report.transaction" title="Laporan Barang Masuk & Keluar"/>
            @role('admin')
                <x-sidebar-menu-dropdown-item-dashboard routeName="report.activity" title="Laporan Aktivitas Pengguna"/>
            @endrole
        </x-sidebar-menu-dropdown-dashboard>
    @endhasanyrole


    {{-- ========================================== --}}
    {{-- 6. PENGATURAN & SISTEM (Admin Saja)        --}}
    {{-- ========================================== --}}
    @role('admin')
        <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase dark:text-gray-400">
            PENGATURAN & SISTEM
        </div>

        <x-sidebar-menu-dropdown-dashboard routeName="users.*" title="Manajemen Pengguna">
            <x-sidebar-menu-dropdown-item-dashboard routeName="users.index" title="Daftar Pengguna"/>
            <x-sidebar-menu-dropdown-item-dashboard routeName="users.create" title="Tambah Pengguna"/>
        </x-sidebar-menu-dropdown-dashboard>

        <x-sidebar-menu-dashboard routeName="settings.index" title="Pengaturan Aplikasi"/>
    @endrole
</x-sidebar-dashboard>