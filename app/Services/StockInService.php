<?php

namespace App\Services;

use App\Models\StockTransaction;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\StockTransactionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class StockInService
{
    public function __construct(
        protected StockTransactionRepositoryInterface $stockTransactionRepository,
        protected ProductRepositoryInterface $productRepository
    ) {}

    public function getPaginatedStockIn(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return $this->stockTransactionRepository->getByTypePaginated('in', $filters, $perPage);
    }

    public function recordStockIn(array $data, ?int $userId = null): StockTransaction
    {
        return DB::transaction(function () use ($data, $userId) {
            $product = $this->productRepository->findById($data['product_id']);
            if (!$product) {
                throw new \InvalidArgumentException("Produk tidak ditemukan.");
            }

            if ($data['quantity'] <= 0) {
                throw new \InvalidArgumentException("Jumlah barang masuk harus lebih besar dari 0.");
            }

            // Generate code TRX-IN-YYYYMMDD-XXXX
            $code = 'TRX-IN-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));

            $transaction = $this->stockTransactionRepository->create([
                'transaction_code' => $code,
                'type' => 'in',
                'product_id' => $product->id,
                'supplier_id' => $data['supplier_id'] ?? $product->supplier_id,
                'user_id' => $userId,
                'quantity' => $data['quantity'],
                'unit_price' => $data['unit_price'] ?? $product->buy_price,
                'transaction_date' => $data['transaction_date'] ?? date('Y-m-d'),
                'notes' => $data['notes'] ?? null,
            ]);

            // Automatic stock update: Add quantity to product current_stock
            $newStock = $product->current_stock + $data['quantity'];
            $this->productRepository->updateStock($product->id, $newStock);

            return $transaction;
        });
    }
}
