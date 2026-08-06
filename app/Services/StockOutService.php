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

            // Pengecekan stok saat staf melakukan input
            if ($product->current_stock < $data['quantity']) {
                throw new Exception("Stok tidak mencukupi! Stok saat ini: {$product->current_stock} {$product->unit}, jumlah diminta: {$data['quantity']} {$product->unit}.");
            }

            // Generate code TRX-OUT-YYYYMMDD-XXXX
            $code = 'TRX-OUT-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));

            // HANYA MENCATAT TRANSAKSI, STOK TIDAK DIKURANGI DULU
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
                'status' => 'pending', // Pastikan defaultnya pending
            ]);

            return $transaction;
        });
    }

    public function confirmStockOut(StockTransaction $transaction, int $userId): StockTransaction
    {
        return DB::transaction(function () use ($transaction, $userId) {
            if ($transaction->type !== 'out') {
                throw new \InvalidArgumentException('Transaksi ini bukan transaksi barang keluar.');
            }
            if ($transaction->status !== 'pending') {
                throw new Exception('Transaksi ini sudah diproses sebelumnya.');
            }

            $product = $this->productRepository->findById($transaction->product_id);

            // PENGECEKAN ULANG: Pastikan stok masih cukup saat dikonfirmasi
            // (Mencegah kasus dimana stok habis dipakai transaksi lain yang dikonfirmasi duluan)
            if ($product->current_stock < $transaction->quantity) {
                throw new Exception("Gagal konfirmasi! Stok saat ini tersisa {$product->current_stock}, tidak cukup untuk mengeluarkan {$transaction->quantity}.");
            }

            // BARU DI SINI STOK DIKURANGI
            $newStock = $product->current_stock - $transaction->quantity;
            $this->productRepository->updateStock($product->id, $newStock);

            $transaction->update([
                'status'       => 'confirmed',
                'confirmed_by' => $userId,
                'confirmed_at' => now(),
            ]);

            return $transaction;
        });
    }

    public function rejectStockOut(StockTransaction $transaction, int $userId): StockTransaction
    {
        if ($transaction->type !== 'out') {
            throw new \InvalidArgumentException('Transaksi ini bukan transaksi barang keluar.');
        }
        if ($transaction->status !== 'pending') {
            throw new Exception('Transaksi ini sudah diproses sebelumnya.');
        }

        // TIDAK PERLU REVERT STOK, KARENA DARI AWAL STOK BELUM DIKURANGI
        $transaction->update([
            'status'       => 'rejected',
            'confirmed_by' => $userId,
            'confirmed_at' => now(),
        ]);

        return $transaction;
    }
}