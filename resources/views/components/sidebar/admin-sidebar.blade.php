<x-sidebar-dashboard>
    {{-- 1. DASHBOARD --}}
    <div class="px-3 pt-2 pb-1 text-[11px] font-bold tracking-wider text-gray-400 uppercase dark:text-gray-500">
        DASHBOARD
    </div>
    @role('admin')
        <x-sidebar-menu-dashboard routeName="dashboard" activeRoute="dashboard" title="Dashboard Admin">
            <x-slot:icon>
                <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 00-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 00-1 1m-6 0h6"/></svg>
            </x-slot:icon>
        </x-sidebar-menu-dashboard>
    @endrole

    @role('manajer')
        <x-sidebar-menu-dashboard routeName="warehouse.dashboard" activeRoute="warehouse.dashboard" title="Dashboard Manajer">
            <x-slot:icon>
                <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            </x-slot:icon>
        </x-sidebar-menu-dashboard>
    @endrole

    @role('staff')
        <x-sidebar-menu-dashboard routeName="dashboard-staff.index" activeRoute="dashboard-staff.*" title="Dashboard Staff">
            <x-slot:icon>
                <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </x-slot:icon>
        </x-sidebar-menu-dashboard>
    @endrole


    {{-- 2. MANAJEMEN PRODUK --}}
    @hasanyrole('admin|manajer')
        <div class="px-3 pt-4 pb-1 text-[11px] font-bold tracking-wider text-gray-400 uppercase dark:text-gray-500">
            MANAJEMEN PRODUK
        </div>

        <x-sidebar-menu-dashboard routeName="products.index" activeRoute="products.index" title="Daftar Produk">
            <x-slot:icon>
                <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </x-slot:icon>
        </x-sidebar-menu-dashboard>

        @role('admin')
            {{-- <x-sidebar-menu-dashboard routeName="products.create" activeRoute="products.create" title="Tambah Produk">
                <x-slot:icon>
                    <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </x-slot:icon>
            </x-sidebar-menu-dashboard> --}}

            <x-sidebar-menu-dashboard routeName="categories.index" activeRoute="categories.*" title="Kategori Produk">
                <x-slot:icon>
                    <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                </x-slot:icon>
            </x-sidebar-menu-dashboard>

            <x-sidebar-menu-dashboard routeName="attributes.index" activeRoute="attributes.*" title="Atribut Produk">
                <x-slot:icon>
                    <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                </x-slot:icon>
            </x-sidebar-menu-dashboard>

            <x-sidebar-menu-dashboard routeName="products.import" activeRoute="products.import" title="Import Produk">
                <x-slot:icon>
                    <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                </x-slot:icon>
            </x-sidebar-menu-dashboard>

            <x-sidebar-menu-dashboard routeName="products.export" activeRoute="products.export" title="Export Produk">
                <x-slot:icon>
                    <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                </x-slot:icon>
            </x-sidebar-menu-dashboard>
        @endrole
    @endhasanyrole


    {{-- 3. MANAJEMEN STOK --}}
    <div class="px-3 pt-4 pb-1 text-[11px] font-bold tracking-wider text-gray-400 uppercase dark:text-gray-500">
        MANAJEMEN STOK
    </div>

    <x-sidebar-menu-dashboard routeName="stock-in.index" activeRoute="stock-in.index" title="Riwayat Barang Masuk">
        <x-slot:icon>
            <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
        </x-slot:icon>
    </x-sidebar-menu-dashboard>

    @hasanyrole('admin|manajer')
        <x-sidebar-menu-dashboard routeName="stock-in.create" activeRoute="stock-in.create" title="Catat Barang Masuk">
            <x-slot:icon>
                <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            </x-slot:icon>
        </x-sidebar-menu-dashboard>
    @endhasanyrole

    <x-sidebar-menu-dashboard routeName="stock-out.index" activeRoute="stock-out.index" title="Riwayat Barang Keluar">
        <x-slot:icon>
            <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
        </x-slot:icon>
    </x-sidebar-menu-dashboard>

    @hasanyrole('admin|manajer')
        <x-sidebar-menu-dashboard routeName="stock-out.create" activeRoute="stock-out.create" title="Catat Barang Keluar">
            <x-slot:icon>
                <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </x-slot:icon>
        </x-sidebar-menu-dashboard>

        <x-sidebar-menu-dashboard routeName="stock-opname.index" activeRoute="stock-opname.index" title="Riwayat Stock Opname">
            <x-slot:icon>
                <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
            </x-slot:icon>
        </x-sidebar-menu-dashboard>

        <x-sidebar-menu-dashboard routeName="stock-opname.create" activeRoute="stock-opname.create" title="Pemeriksaan Stok Opname">
            <x-slot:icon>
                <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            </x-slot:icon>
        </x-sidebar-menu-dashboard>
    @endhasanyrole


    {{-- 4. SUPPLIER --}}
    @hasanyrole('admin|manajer')
        <div class="px-3 pt-4 pb-1 text-[11px] font-bold tracking-wider text-gray-400 uppercase dark:text-gray-500">
            MANAJEMEN SUPPLIER
        </div>
        <x-sidebar-menu-dashboard routeName="suppliers.index" activeRoute="suppliers.index" title="Daftar Supplier">
            <x-slot:icon>
                <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m3 0h1m-4-8l-2-2m0 0l-2 2m2-2v4"/></svg>
            </x-slot:icon>
        </x-sidebar-menu-dashboard>

        @role('admin')
            {{-- <x-sidebar-menu-dashboard routeName="suppliers.create" activeRoute="suppliers.create" title="Tambah Supplier">
                <x-slot:icon>
                    <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                </x-slot:icon>
            </x-sidebar-menu-dashboard> --}}
        @endrole
    @endhasanyrole


   {{-- 5. LAPORAN --}}
    @hasanyrole('admin|manajer')
        <div class="px-3 pt-4 pb-1 text-[11px] font-bold tracking-wider text-gray-400 uppercase dark:text-gray-500">
            LAPORAN
        </div>

        <x-sidebar-menu-dashboard routeName="report.index" activeRoute="report.index" title="Laporan">
            <x-slot:icon>
                <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </x-slot:icon>
        </x-sidebar-menu-dashboard>
    @endhasanyrole


    {{-- 6. PENGATURAN & SISTEM --}}
    @role('admin')
        <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase dark:text-gray-400">
            PENGATURAN SISTEM
        </div>

        <x-sidebar-menu-dashboard routeName="users.index" activeRoute="users.index" title="Daftar Pengguna">
            <x-slot:icon>
                <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </x-slot:icon>
        </x-sidebar-menu-dashboard>

        {{-- <x-sidebar-menu-dashboard routeName="users.create" activeRoute="users.create" title="Tambah Pengguna">
            <x-slot:icon>
                <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            </x-slot:icon>
        </x-sidebar-menu-dashboard> --}}

        <x-sidebar-menu-dashboard routeName="settings.index" activeRoute="settings.*" title="Pengaturan Aplikasi">
            <x-slot:icon>
                <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </x-slot:icon>
        </x-sidebar-menu-dashboard>
    @endrole
</x-sidebar-dashboard>