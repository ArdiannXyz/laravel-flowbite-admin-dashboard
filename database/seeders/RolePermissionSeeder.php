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
            'view-products',
            'manage-stock',
            'view-reports',
            'manage-settings',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $admin->syncPermissions($permissions); // Admin mendapat semua permission

        $manajerGudang = Role::firstOrCreate(['name' => 'manajer', 'guard_name' => 'web']);
        $manajerGudang->syncPermissions(['view-products', 'manage-stock', 'view-reports']);

        $staffGudang = Role::firstOrCreate(['name' => 'staff', 'guard_name' => 'web']);
        $staffGudang->syncPermissions(['manage-stock']);
    }
}