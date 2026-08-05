<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $elektronik = Category::where('slug', 'elektronik')->first();
        $pakaian = Category::where('slug', 'pakaian-tekstil')->first();
        $makanan = Category::where('slug', 'makanan-minuman')->first();
        $kantor = Category::where('slug', 'peralatan-kantor')->first();

        $supElektronik = Supplier::where('code', 'SUP-ELK-001')->first();
        $supPakaian = Supplier::where('code', 'SUP-TEX-002')->first();
        $supMakanan = Supplier::where('code', 'SUP-FNB-003')->first();

        $products = [
            [
                'sku' => 'PRD-ELK-001',
                'name' => 'Barcode Scanner Wireless 2.4G',
                'category_id' => $elektronik?->id ?? 1,
                'supplier_id' => $supElektronik?->id,
                'buy_price' => 450000,
                'sell_price' => 650000,
                'min_stock' => 5,
                'current_stock' => 18,
                'unit' => 'unit',
                'description' => 'Scanner barcode nirkabel resolusi tinggi dengan baterai 2000mAh.'
            ],
            [
                'sku' => 'PRD-ELK-002',
                'name' => 'Thermal Label Printer 80mm',
                'category_id' => $elektronik?->id ?? 1,
                'supplier_id' => $supElektronik?->id,
                'buy_price' => 850000,
                'sell_price' => 1250000,
                'min_stock' => 4,
                'current_stock' => 3, // LOW STOCK TRIGGER!
                'unit' => 'unit',
                'description' => 'Printer thermal cetak resi dan label pengiriman gudang cepat.'
            ],
            [
                'sku' => 'PRD-TEX-001',
                'name' => 'Kardus Double Wall 40x30x30 cm',
                'category_id' => $pakaian?->id ?? 2,
                'supplier_id' => $supPakaian?->id,
                'buy_price' => 12000,
                'sell_price' => 18000,
                'min_stock' => 50,
                'current_stock' => 240,
                'unit' => 'pcs',
                'description' => 'Kardus tebal tahan benturan untuk packaging barang keluar.'
            ],
            [
                'sku' => 'PRD-FNB-001',
                'name' => 'Bubble Wrap Premium 1.25m x 50m',
                'category_id' => $makanan?->id ?? 3,
                'supplier_id' => $supMakanan?->id,
                'buy_price' => 115000,
                'sell_price' => 160000,
                'min_stock' => 10,
                'current_stock' => 4, // LOW STOCK TRIGGER!
                'unit' => 'roll',
                'description' => 'Plastik gelembung tebal pelindung barang fragile.'
            ],
            [
                'sku' => 'PRD-OFC-001',
                'name' => 'Lakban Bening 2 Inch 90 Yard',
                'category_id' => $kantor?->id ?? 4,
                'supplier_id' => $supElektronik?->id,
                'buy_price' => 9500,
                'sell_price' => 14000,
                'min_stock' => 20,
                'current_stock' => 85,
                'unit' => 'roll',
                'description' => 'Lakban perekat kuat untuk lakban dus kemasan.'
            ]
        ];

        foreach ($products as $prd) {
            Product::updateOrCreate(['sku' => $prd['sku']], $prd);
        }
    }
}
