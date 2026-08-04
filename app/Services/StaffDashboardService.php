<?php

namespace App\Services;

use App\Repositories\Contracts\StockTransactionRepositoryInterface;

class StaffDashboardService
{
    public function __construct(
        protected StockTransactionRepositoryInterface $stockTransactionRepository
    ) {}

    public function getStaffDashboardData(): array
    {
        // Mengambil transaksi barang masuk & keluar terbaru (top 5 item)
        $barangMasukPaginated = $this->stockTransactionRepository->getByTypePaginated('in', [], 5);
        $barangKeluarPaginated = $this->stockTransactionRepository->getByTypePaginated('out', [], 5);

        return [
            'barangMasuk'       => $barangMasukPaginated->items(),
            'barangKeluar'      => $barangKeluarPaginated->items(),
            'barangMasukCount'  => $barangMasukPaginated->total(),
            'barangKeluarCount' => $barangKeluarPaginated->total(),
        ];
    }
}