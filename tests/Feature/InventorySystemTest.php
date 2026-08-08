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
        $user = User::role('manajer')->first() ?? User::first();
        if (!$user->hasRole('manajer')) {
            $user->assignRole('manajer');
        }
        $response = $this->actingAs($user)->get(route('warehouse.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Dashboard Manajer Gudang');
    }

    public function test_can_create_new_product()
    {
        $user = User::role('admin')->first() ?? User::first();
        $category = Category::first();

        $response = $this->actingAs($user)->post(route('products.store'), [
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

    public function test_warehouse_manager_can_view_product_list_and_details()
    {
        $manager = User::role('manajer')->first();
        $product = Product::first();

        // 1. Can view index
        $indexResponse = $this->actingAs($manager)->get(route('products.index'));
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee($product->name);
        $indexResponse->assertDontSee('Tambah Produk Baru');

        // 2. Can view details
        $showResponse = $this->actingAs($manager)->get(route('products.show', $product->id));
        $showResponse->assertStatus(200);
        $showResponse->assertSee($product->name);
        $showResponse->assertDontSee('Edit Produk');
    }

    public function test_warehouse_manager_cannot_create_edit_or_delete_product()
    {
        $manager = User::role('manajer')->first();
        $product = Product::first();
        $category = Category::first();

        // 1. Cannot access create form
        $this->actingAs($manager)->get(route('products.create'))->assertStatus(403);

        // 2. Cannot store product
        $this->actingAs($manager)->post(route('products.store'), [
            'name' => 'Unauthorized Product',
            'category_id' => $category->id,
            'buy_price' => 10000,
            'sell_price' => 15000,
            'min_stock' => 1,
            'current_stock' => 5,
            'unit' => 'unit',
        ])->assertStatus(403);

        // 3. Cannot access edit form
        $this->actingAs($manager)->get(route('products.edit', $product->id))->assertStatus(403);

        // 4. Cannot update product
        $this->actingAs($manager)->put(route('products.update', $product->id), [
            'name' => 'Updated Name',
        ])->assertStatus(403);

        // 5. Cannot delete product
        $this->actingAs($manager)->delete(route('products.destroy', $product->id))->assertStatus(403);
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

    public function test_stock_in_recalculates_moving_average_buy_price()
    {
        $product = Product::first();
        $product->update([
            'current_stock' => 10,
            'buy_price' => 100000,
        ]);

        $stockInService = app(StockInService::class);

        // 1. Barang masuk 10 unit dengan kenaikan harga menjadi Rp 120.000
        // (10 * 100.000 + 10 * 120.000) / 20 = 110.000
        $stockInService->recordStockIn([
            'product_id' => $product->id,
            'quantity' => 10,
            'unit_price' => 120000,
            'transaction_date' => date('Y-m-d'),
        ]);

        $product->refresh();
        $this->assertEquals(20, $product->current_stock);
        $this->assertEquals(110000, (float) $product->buy_price);

        // 2. Barang masuk lagi 10 unit dengan penurunan harga menjadi Rp 80.000
        // (20 * 110.000 + 10 * 80.000) / 30 = 100.000
        $stockInService->recordStockIn([
            'product_id' => $product->id,
            'quantity' => 10,
            'unit_price' => 80000,
            'transaction_date' => date('Y-m-d'),
        ]);

        $product->refresh();
        $this->assertEquals(30, $product->current_stock);
        $this->assertEquals(100000, (float) $product->buy_price);
    }

    public function test_stock_out_request_validation_fails_when_exceeding_stock()
    {
        $user = User::first();
        $product = Product::first();
        $product->update(['current_stock' => 29]);

        $response = $this->actingAs($user)->post(route('stock-out.store'), [
            'product_id' => $product->id,
            'quantity' => 30, // Exceeds 29
            'transaction_date' => date('Y-m-d'),
        ]);

        $response->assertSessionHasErrors(['quantity']);
    }

    public function test_stock_opname_request_validation_fails_when_exceeding_stock()
    {
        $user = User::first();
        $product = Product::first();
        $product->update(['current_stock' => 29]);

        $response = $this->actingAs($user)->post(route('stock-opname.store'), [
            'product_id' => $product->id,
            'physical_stock' => 30, // Exceeds 29
            'opname_date' => date('Y-m-d'),
        ]);

        $response->assertSessionHasErrors(['physical_stock']);
    }

    public function test_warehouse_manager_can_view_supplier_list_and_details()
    {
        $user = User::role('manajer')->first() ?? User::first();
        if (!$user->hasRole('manajer')) {
            $user->assignRole('manajer');
        }

        $supplier = Supplier::first();

        // 1. Can view supplier index page
        $response = $this->actingAs($user)->get(route('suppliers.index'));
        $response->assertStatus(200);
        $response->assertSee('Daftar Supplier (Pemasok)');

        // 2. Can view supplier details page
        $responseDetails = $this->actingAs($user)->get(route('suppliers.show', $supplier->id));
        $responseDetails->assertStatus(200);
        $responseDetails->assertSee($supplier->name);

        // 3. Cannot access supplier create form
        $this->actingAs($user)->get(route('suppliers.create'))->assertStatus(403);

        // 4. Cannot access supplier edit form
        $this->actingAs($user)->get(route('suppliers.edit', $supplier->id))->assertStatus(403);
    }

    public function test_admin_can_create_update_and_delete_supplier()
    {
        $admin = User::role('admin')->first() ?? User::first();
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        // 1. Create Supplier
        $createResponse = $this->actingAs($admin)->post(route('suppliers.store'), [
            'name' => 'PT Test Supplier Indonesia',
            'code' => 'SUP-TEST-999',
            'email' => 'contact@testsupplier.com',
            'phone' => '081299990000',
            'address' => 'Jl. Test No. 123',
        ]);

        $createResponse->assertRedirect(route('suppliers.index'));
        $this->assertDatabaseHas('suppliers', [
            'code' => 'SUP-TEST-999',
            'name' => 'PT Test Supplier Indonesia',
        ]);

        $supplier = Supplier::where('code', 'SUP-TEST-999')->first();

        // 2. Update Supplier
        $updateResponse = $this->actingAs($admin)->put(route('suppliers.update', $supplier->id), [
            'name' => 'PT Test Supplier Indonesia Updated',
            'code' => 'SUP-TEST-999',
            'email' => 'updated@testsupplier.com',
        ]);

        $updateResponse->assertRedirect(route('suppliers.index'));
        $this->assertDatabaseHas('suppliers', [
            'id' => $supplier->id,
            'name' => 'PT Test Supplier Indonesia Updated',
        ]);

        // 3. Delete Supplier
        $deleteResponse = $this->actingAs($admin)->delete(route('suppliers.destroy', $supplier->id));
        $deleteResponse->assertRedirect(route('suppliers.index'));
        $this->assertDatabaseMissing('suppliers', [
            'id' => $supplier->id,
        ]);
    }

    public function test_global_search_returns_relevant_results()
    {
        $user = User::first();
        $product = Product::first();

        $response = $this->actingAs($user)->get(route('search.global', ['q' => substr($product->name, 0, 4)]));
        $response->assertStatus(200);
        $response->assertSee('Hasil Pencarian Global');
        $response->assertSee($product->name);
    }
}
