<?php

namespace App\Services;

use App\Models\StockTransaction;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\StockTransactionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Exception;

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

            // --- PERUBAHAN DI SINI ---
            // Semua transaksi baru otomatis statusnya PENDING
            // Tidak ada pengecekan Role Admin/Manager di sini
            
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
                'status' => 'pending',        // Selalu pending
                'confirmed_by' => null,       // Belum dikonfirmasi
                'confirmed_at' => null,       // Belum dikonfirmasi
            ]);

            return $transaction;
        });
    }

    public function confirmStockIn(StockTransaction $transaction, int $userId): StockTransaction
    {
        return DB::transaction(function () use ($transaction, $userId) {
            if ($transaction->type !== 'in') {
                throw new \InvalidArgumentException('Transaksi ini bukan transaksi barang masuk.');
            }
            if ($transaction->status !== 'pending') {
                throw new Exception('Transaksi ini sudah diproses sebelumnya.');
            }

            $product = $this->productRepository->findById($transaction->product_id);

            // LOGIKA PENAMBAHAN STOK & HARGA RATA-RATA DIPINDAH KESINI
            $oldStock = max(0, (int) $product->current_stock);
            $oldPrice = (float) $product->buy_price;
            $incomingQty = (int) $transaction->quantity;
            $unitPrice = (float) $transaction->unit_price;

            $newStock = $oldStock + $incomingQty;
            $totalQtyForAvg = $oldStock + $incomingQty;

            if ($totalQtyForAvg > 0) {
                $newAvgPrice = (($oldStock * $oldPrice) + ($incomingQty * $unitPrice)) / $totalQtyForAvg;
            } else {
                $newAvgPrice = $unitPrice;
            }

            // Update product stock and purchase price (AVG)
            $this->productRepository->updateStockAndPrice($product->id, $newStock, $newAvgPrice);

            // Update Status Transaksi
            $transaction->update([
                'status'       => 'confirmed',
                'confirmed_by' => $userId,
                'confirmed_at' => now(),
            ]);

            return $transaction;
        });
    }

    public function rejectStockIn(StockTransaction $transaction, int $userId): StockTransaction
    {
        if ($transaction->type !== 'in') {
            throw new \InvalidArgumentException('Transaksi ini bukan transaksi barang masuk.');
        }
        if ($transaction->status !== 'pending') {
            throw new Exception('Transaksi ini sudah diproses sebelumnya.');
        }

        // TIDAK PERLU REVERT STOK, KARENA STOK MEMANG BELUM DITAMBAH DI AWAL
        $transaction->update([
            'status'       => 'rejected',
            'confirmed_by' => $userId,
            'confirmed_at' => now(),
        ]);

        return $transaction;
    }
}