<?php

namespace App\Services;

use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\StockTransactionRepositoryInterface;
use App\Repositories\Contracts\StockOpnameRepositoryInterface;

class WarehouseDashboardService
{
    public function __construct(
        protected ProductRepositoryInterface $productRepository,
        protected StockTransactionRepositoryInterface $stockTransactionRepository,
        protected StockOpnameRepositoryInterface $stockOpnameRepository
    ) {}

    public function getDashboardSummary(): array
    {
        // Auto-konfirmasi transaksi pending yang dibuat oleh Admin/Manajer
        $pendingTransactions = \App\Models\StockTransaction::where('status', 'pending')->get();
        foreach ($pendingTransactions as $trx) {
            $user = $trx->user_id ? \App\Models\User::find($trx->user_id) : null;
            if (!$user || $user->hasRole('admin') || $user->hasRole('manajer') || ($user->role ?? '') === 'admin' || ($user->role ?? '') === 'manajer') {
                try {
                    if ($trx->type === 'out') {
                        $this->stockTransactionRepository; // check
                        app(\App\Services\StockOutService::class)->confirmStockOut($trx, $trx->user_id ?? 1);
                    } else if ($trx->type === 'in') {
                        app(\App\Services\StockInService::class)->confirmStockIn($trx, $trx->user_id ?? 1);
                    }
                } catch (\Throwable $e) {
                    // ignore
                }
            }
        }

        return [
            'total_products' => $this->productRepository->countTotalProducts(),
            'low_stock_count' => $this->productRepository->countLowStockProducts(),
            'today_stock_in_count' => $this->stockTransactionRepository->countTodayTransactionsByType('in'),
            'today_stock_in_qty' => $this->stockTransactionRepository->sumTodayQuantityByType('in'),
            'today_stock_out_count' => $this->stockTransactionRepository->countTodayTransactionsByType('out'),
            'today_stock_out_qty' => $this->stockTransactionRepository->sumTodayQuantityByType('out'),
            'low_stock_products' => $this->productRepository->getLowStockProducts(),
            'recent_transactions' => $this->stockTransactionRepository->getRecentTransactions(15),
            'recent_opnames' => $this->stockOpnameRepository->getRecentOpnames(5),
        ];
    }
}
