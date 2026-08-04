<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'manage-users',
            'manage-categories',
            'manage-suppliers',
            'manage-products',
            'manage-stock',
            'view-reports',
            'manage-settings',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $admin = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $admin->syncPermissions($permissions); // Admin dapat semua permission

        $manajerGudang = Role::firstOrCreate(['name' => 'Manajer Gudang', 'guard_name' => 'web']);
        $manajerGudang->syncPermissions(['manage-products', 'manage-stock', 'view-reports']);

        $staffGudang = Role::firstOrCreate(['name' => 'Staff Gudang', 'guard_name' => 'web']);
        $staffGudang->syncPermissions(['manage-stock']);
    }
}