<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan role sudah ada sebelum di-assign
        foreach (['admin', 'manajer', 'staff'] as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        $admin = User::updateOrCreate(
            ['email' => 'admin@stockify.test'],
            [
                'name' => 'Administrator Stockify',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );
        $admin->syncRoles(['admin']);

        $manager = User::updateOrCreate(
            ['email' => 'manager@stockify.test'],
            [
                'name' => 'Budi Santoso (Manajer Gudang)',
                'password' => Hash::make('password'),
                'role' => 'manajer', // disamakan dengan yang dipakai di routes/sidebar
            ]
        );
        $manager->syncRoles(['manajer']);

        $staff = User::updateOrCreate(
            ['email' => 'staff@stockify.test'],
            [
                'name' => 'Siti Rahma (Staff Gudang)',
                'password' => Hash::make('password'),
                'role' => 'staff',
            ]
        );
        $staff->syncRoles(['staff']);

        $this->call([
            CategorySeeder::class,
            SupplierSeeder::class,
            ProductSeeder::class,
        ]);
    }
}