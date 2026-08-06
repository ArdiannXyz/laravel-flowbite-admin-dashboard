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

            $unitPrice = isset($data['unit_price']) && is_numeric($data['unit_price']) 
                ? (float) $data['unit_price'] 
                : (float) $product->buy_price;

            $transaction = $this->stockTransactionRepository->create([
                'transaction_code' => $code,
                'type' => 'in',
                'product_id' => $product->id,
                'supplier_id' => $data['supplier_id'] ?? $product->supplier_id,
                'user_id' => $userId,
                'quantity' => $data['quantity'],
                'unit_price' => $unitPrice,
                'transaction_date' => $data['transaction_date'] ?? date('Y-m-d'),
                'notes' => $data['notes'] ?? null,
            ]);

            // Calculate Moving Average Purchase Price (AVG)
            $oldStock = max(0, (int) $product->current_stock);
            $oldPrice = (float) $product->buy_price;
            $incomingQty = (int) $data['quantity'];

            $newStock = $product->current_stock + $incomingQty;
            $totalQtyForAvg = $oldStock + $incomingQty;

            if ($totalQtyForAvg > 0) {
                $newAvgPrice = (($oldStock * $oldPrice) + ($incomingQty * $unitPrice)) / $totalQtyForAvg;
            } else {
                $newAvgPrice = $unitPrice;
            }

            // Update product stock and purchase price (AVG)
            $this->productRepository->updateStockAndPrice($product->id, $newStock, $newAvgPrice);

            return $transaction;
        });
    }
}
