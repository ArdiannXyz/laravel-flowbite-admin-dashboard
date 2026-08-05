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
        return [
            'total_products' => $this->productRepository->countTotalProducts(),
            'low_stock_count' => $this->productRepository->countLowStockProducts(),
            'today_stock_in_count' => $this->stockTransactionRepository->countTodayTransactionsByType('in'),
            'today_stock_in_qty' => $this->stockTransactionRepository->sumTodayQuantityByType('in'),
            'today_stock_out_count' => $this->stockTransactionRepository->countTodayTransactionsByType('out'),
            'today_stock_out_qty' => $this->stockTransactionRepository->sumTodayQuantityByType('out'),
            'low_stock_products' => $this->productRepository->getLowStockProducts(),
            'recent_transactions' => $this->stockTransactionRepository->getRecentTransactions(8),
            'recent_opnames' => $this->stockOpnameRepository->getRecentOpnames(5),
        ];
    }
}
