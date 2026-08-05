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
            ['name' => 'Peralatan Medis & Kesehatan', 'slug' => 'peralatan-medis-kesehatan', 'description' => 'Alat kesehatan, medis, dan perlengkapan P3K'],
            ['name' => 'Furnitur & Perlengkapan Rumah', 'slug' => 'furnitur-perlengkapan-rumah', 'description' => 'Meja, kursi, rak, dan perabot gudang'],
            ['name' => 'Bahan Bangunan & Perkakas', 'slug' => 'bahan-bangunan-perkakas', 'description' => 'Perkakas teknik, cat, dan bahan konstruksi'],
            ['name' => 'Kosmetik & Perawatan Diri', 'slug' => 'kosmetik-perawatan-diri', 'description' => 'Produk kecantikan, sabun, dan perawatan'],
            ['name' => 'Olahraga & Outdoor', 'slug' => 'olahraga-outdoor', 'description' => 'Peralatan olah raga dan kegiatan luar ruangan'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
