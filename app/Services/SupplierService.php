<?php

namespace App\Services;

use App\Models\Supplier;
use App\Repositories\Contracts\SupplierRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SupplierService
{
    public function __construct(
        protected SupplierRepositoryInterface $supplierRepository
    ) {}

    public function getPaginatedSuppliers(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return $this->supplierRepository->getAllPaginated($filters, $perPage);
    }

    public function getSupplierById(int $id): ?Supplier
    {
        return $this->supplierRepository->findById($id);
    }

    public function createSupplier(array $data): Supplier
    {
        if (empty($data['code'])) {
            $data['code'] = $this->generateSupplierCode($data['name']);
        }

        return $this->supplierRepository->create($data);
    }

    public function updateSupplier(int $id, array $data): bool
    {
        $supplier = $this->supplierRepository->findById($id);
        if (!$supplier) {
            return false;
        }

        // Kode supplier dikunci setelah dibuat, jangan pernah ikut diupdate
        unset($data['code']);

        return $this->supplierRepository->update($id, $data);
    }

    public function deleteSupplier(int $id): array
    {
        $supplier = $this->supplierRepository->findById($id);

        if (!$supplier) {
            return ['success' => false, 'message' => 'Supplier tidak ditemukan.'];
        }

        if ($supplier->products()->count() > 0) {
            return [
                'success' => false,
                'message' => "Supplier '{$supplier->name}' tidak dapat dihapus karena masih memiliki produk terikat.",
            ];
        }

        $this->supplierRepository->delete($id);

        return ['success' => true, 'message' => "Supplier '{$supplier->name}' berhasil dihapus."];
    }

    /**
     * Generate kode supplier otomatis dengan format: SUP-[3 HURUF NAMA]-[NOMOR URUT]
     * Contoh: SUP-JAY-001, SUP-JAY-002, dst.
     */
    protected function generateSupplierCode(string $name): string
    {
        // Buang prefix badan usaha umum (PT, CV, UD, dll) sebelum ambil huruf kode
        $cleanName = preg_replace('/^(PT|CV|UD|PD|Fa)\.?\s+/i', '', trim($name));

        $nameCode = strtoupper(
            substr(preg_replace('/[^A-Za-z]/', '', $cleanName), 0, 3)
        );
        $nameCode = $nameCode ?: 'GEN';

        $lastCode = Supplier::where('code', 'like', "SUP-{$nameCode}-%")
            ->orderByDesc('id')
            ->value('code');

        $nextNumber = 1;
        if ($lastCode && preg_match('/-(\d+)$/', $lastCode, $matches)) {
            $nextNumber = ((int) $matches[1]) + 1;
        }

        $code = sprintf('SUP-%s-%03d', $nameCode, $nextNumber);

        while (Supplier::where('code', $code)->exists()) {
            $nextNumber++;
            $code = sprintf('SUP-%s-%03d', $nameCode, $nextNumber);
        }

        return $code;
    }
}