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
        // FILTER PENTING: Hanya ambil yang berstatus 'pending'
        $filters = [
            'status' => 'pending'
        ];

        // Mengambil transaksi barang masuk & keluar terbaru (top 5 item) yang masih PENDING
        $barangMasukPaginated = $this->stockTransactionRepository->getByTypePaginated('in', $filters, 5);
        $barangKeluarPaginated = $this->stockTransactionRepository->getByTypePaginated('out', $filters, 5);

        return [
            'barangMasuk'       => $barangMasukPaginated->items(),
            'barangKeluar'      => $barangKeluarPaginated->items(),
            'barangMasukCount'  => $barangMasukPaginated->total(),
            'barangKeluarCount' => $barangKeluarPaginated->total(),
        ];
    }
}