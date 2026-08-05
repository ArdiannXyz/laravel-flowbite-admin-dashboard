<?php

namespace App\Services;

use App\Models\StockTransaction;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\StockTransactionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Exception;

class StockOutService
{
    public function __construct(
        protected StockTransactionRepositoryInterface $stockTransactionRepository,
        protected ProductRepositoryInterface $productRepository
    ) {}

    public function getPaginatedStockOut(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return $this->stockTransactionRepository->getByTypePaginated('out', $filters, $perPage);
    }

    public function recordStockOut(array $data, ?int $userId = null): StockTransaction
    {
        return DB::transaction(function () use ($data, $userId) {
            $product = $this->productRepository->findById($data['product_id']);
            if (!$product) {
                throw new Exception("Produk tidak ditemukan.");
            }

            if ($data['quantity'] <= 0) {
                throw new Exception("Jumlah barang keluar harus lebih besar dari 0.");
            }

            // Check stock availability validation!
            if ($product->current_stock < $data['quantity']) {
                throw new Exception("Stok tidak mencukupi! Stok saat ini: {$product->current_stock} {$product->unit}, jumlah diminta: {$data['quantity']} {$product->unit}.");
            }

            // Generate code TRX-OUT-YYYYMMDD-XXXX
            $code = 'TRX-OUT-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));

            $transaction = $this->stockTransactionRepository->create([
                'transaction_code' => $code,
                'type' => 'out',
                'product_id' => $product->id,
                'supplier_id' => null,
                'user_id' => $userId,
                'quantity' => $data['quantity'],
                'unit_price' => $data['unit_price'] ?? $product->sell_price,
                'transaction_date' => $data['transaction_date'] ?? date('Y-m-d'),
                'notes' => $data['notes'] ?? null,
            ]);

            // Automatic stock update: Subtract quantity from product current_stock
            $newStock = $product->current_stock - $data['quantity'];
            $this->productRepository->updateStock($product->id, $newStock);

            return $transaction;
        });
    }
}
