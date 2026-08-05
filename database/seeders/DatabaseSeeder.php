<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed default users for testing
        User::updateOrCreate(
            ['email' => 'admin@stockify.test'],
            [
                'name' => 'Administrator Stockify',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'manager@stockify.test'],
            [
                'name' => 'Budi Santoso (Manajer Gudang)',
                'password' => Hash::make('password'),
                'role' => 'manager',
            ]
        );

        User::updateOrCreate(
            ['email' => 'staff@stockify.test'],
            [
                'name' => 'Siti Rahma (Staff Gudang)',
                'password' => Hash::make('password'),
                'role' => 'staff',
            ]
        );

        $this->call([
            CategorySeeder::class,
            SupplierSeeder::class,
            ProductSeeder::class,
        ]);
    }
}
