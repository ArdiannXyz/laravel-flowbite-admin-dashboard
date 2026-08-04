<?php

namespace App\Services;

use App\Models\StockOpname;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\StockOpnameRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Exception;

class StockOpnameService
{
    public function __construct(
        protected StockOpnameRepositoryInterface $stockOpnameRepository,
        protected ProductRepositoryInterface $productRepository
    ) {}

    public function getPaginatedStockOpnames(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return $this->stockOpnameRepository->getAllPaginated($filters, $perPage);
    }

    public function recordStockOpname(array $data, ?int $userId = null): StockOpname
    {
        return DB::transaction(function () use ($data, $userId) {
            $product = $this->productRepository->findById($data['product_id']);
            if (!$product) {
                throw new Exception("Produk tidak ditemukan.");
            }

            if ($data['physical_stock'] < 0) {
                throw new Exception("Jumlah stok fisik tidak boleh negatif.");
            }

            $systemStock = $product->current_stock;
            $physicalStock = (int) $data['physical_stock'];
            $difference = $physicalStock - $systemStock;

            // Generate code OPN-YYYYMMDD-XXXX
            $code = 'OPN-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));

            $opname = $this->stockOpnameRepository->create([
                'opname_code' => $code,
                'product_id' => $product->id,
                'user_id' => $userId,
                'system_stock' => $systemStock,
                'physical_stock' => $physicalStock,
                'difference' => $difference,
                'opname_date' => $data['opname_date'] ?? date('Y-m-d'),
                'notes' => $data['notes'] ?? null,
            ]);

            // Automatic stock sync: Set product current_stock to physical_stock
            $this->productRepository->updateStock($product->id, $physicalStock);

            return $opname;
        });
    }
}
