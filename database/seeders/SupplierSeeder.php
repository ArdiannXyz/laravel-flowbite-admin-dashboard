<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'PT Jaya Elekrosindo Utama',
                'code' => 'SUP-ELK-001',
                'email' => 'sales@elektrosindo.co.id',
                'phone' => '021-5549021',
                'address' => 'Kawasan Industri Pulogadung Blok B No. 12, Jakarta Timur'
            ],
            [
                'name' => 'CV Sumber Sandang Makmur',
                'code' => 'SUP-TEX-002',
                'email' => 'contact@sumbersandang.com',
                'phone' => '022-7729103',
                'address' => 'Jl. Raya Bandung Garut Km 21, Bandung'
            ],
            [
                'name' => 'PT Pangan Perkasa Abadi',
                'code' => 'SUP-FNB-003',
                'email' => 'order@panganperkasa.co.id',
                'phone' => '031-8930211',
                'address' => 'Jl. Rungkut Industri III No. 8, Surabaya'
            ],
        ];

        foreach ($suppliers as $sup) {
            Supplier::updateOrCreate(['code' => $sup['code']], $sup);
        }
    }
}
