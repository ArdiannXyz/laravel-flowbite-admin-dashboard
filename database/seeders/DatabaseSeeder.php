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
            ['email' => 'adminstockify@gmail.com'],
            [
                'name' => 'Administrator Stockify',
                'password' => Hash::make('admin1234'),
                'role' => 'admin',
            ]
        );
        $admin->syncRoles(['admin']);

        $manager = User::updateOrCreate(
            ['email' => 'managerstockify@gmail.com'],
            [
                'name' => 'Budi Santoso (Manajer Gudang)',
                'password' => Hash::make('manager1234'),
                'role' => 'manajer', // disamakan dengan yang dipakai di routes/sidebar
            ]
        );
        $manager->syncRoles(['manajer']);

        $staff = User::updateOrCreate(
            ['email' => 'staffstockify@gmail.com'],
            [
                'name' => 'Siti Rahma (Staff Gudang)',
                'password' => Hash::make('staff1234'),
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