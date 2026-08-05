<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Elektronik', 'slug' => 'elektronik', 'description' => 'Peralatan elektronik & komponen'],
            ['name' => 'Pakaian & Tekstil', 'slug' => 'pakaian-tekstil', 'description' => 'Seragam garmen dan bahan tekstil'],
            ['name' => 'Makanan & Minuman', 'slug' => 'makanan-minuman', 'description' => 'Produk konsumsi dan kemasan'],
            ['name' => 'Peralatan Kantor', 'slug' => 'peralatan-kantor', 'description' => 'Alat tulis dan perlengkapan kerja'],
            ['name' => 'Otomotif & Sparepart', 'slug' => 'otomotif-sparepart', 'description' => 'Suku cadang dan oli kendaraan'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
