<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use App\Services\StockInService;
use App\Services\StockOutService;
use App\Services\StockOpnameService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventorySystemTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_can_view_warehouse_manager_dashboard()
    {
        $response = $this->get(route('warehouse.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Dashboard Manajer Gudang');
    }

    public function test_can_create_new_product()
    {
        $category = Category::first();

        $response = $this->post(route('products.store'), [
            'name' => 'Barcode Scanner Wireless High-Speed',
            'category_id' => $category->id,
            'buy_price' => 500000,
            'sell_price' => 750000,
            'min_stock' => 5,
            'current_stock' => 10,
            'unit' => 'unit',
        ]);

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseHas('products', [
            'name' => 'Barcode Scanner Wireless High-Speed',
            'current_stock' => 10,
        ]);
    }

    public function test_stock_in_increases_product_stock_automatically()
    {
        $product = Product::first();
        $initialStock = $product->current_stock;
        $stockInQty = 25;

        $stockInService = app(StockInService::class);
        $stockInService->recordStockIn([
            'product_id' => $product->id,
            'quantity' => $stockInQty,
            'transaction_date' => date('Y-m-d'),
            'notes' => 'Penerimaan barang test',
        ]);

        $product->refresh();
        $this->assertEquals($initialStock + $stockInQty, $product->current_stock);
    }

    public function test_stock_out_decreases_product_stock_automatically()
    {
        $product = Product::first();
        $product->update(['current_stock' => 30]);

        $stockOutQty = 10;
        $stockOutService = app(StockOutService::class);
        $stockOutService->recordStockOut([
            'product_id' => $product->id,
            'quantity' => $stockOutQty,
            'transaction_date' => date('Y-m-d'),
            'notes' => 'Pengeluaran barang test',
        ]);

        $product->refresh();
        $this->assertEquals(20, $product->current_stock);
    }

    public function test_stock_out_fails_when_quantity_exceeds_available_stock()
    {
        $product = Product::first();
        $product->update(['current_stock' => 5]);

        $this->expectException(\Exception::class);

        $stockOutService = app(StockOutService::class);
        $stockOutService->recordStockOut([
            'product_id' => $product->id,
            'quantity' => 10, // Exceeds available stock (5)
            'transaction_date' => date('Y-m-d'),
        ]);
    }

    public function test_stock_opname_adjusts_product_stock_to_physical_count()
    {
        $product = Product::first();
        $product->update(['current_stock' => 50]);

        $physicalStock = 42; // Difference: -8
        $stockOpnameService = app(StockOpnameService::class);
        $opname = $stockOpnameService->recordStockOpname([
            'product_id' => $product->id,
            'physical_stock' => $physicalStock,
            'opname_date' => date('Y-m-d'),
            'notes' => 'Pemeriksaan opname bulanan',
        ]);

        $product->refresh();
        $this->assertEquals(42, $product->current_stock);
        $this->assertEquals(-8, $opname->difference);
    }
}
