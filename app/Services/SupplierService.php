<?php

namespace App\Services;

use App\Models\Supplier;
use App\Repositories\Contracts\SupplierRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class SupplierService
{
    public function __construct(
        protected SupplierRepositoryInterface $supplierRepository
    ) {}

    public function getPaginatedSuppliers(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return $this->supplierRepository->getAllPaginated($filters, $perPage);
    }

    public function getAllSuppliers(): Collection
    {
        return $this->supplierRepository->getAll();
    }

    public function getSupplierById(int $id): ?Supplier
    {
        return $this->supplierRepository->findById($id);
    }

    public function createSupplier(array $data): Supplier
    {
        if (empty($data['code'])) {
            $data['code'] = 'SUP-' . strtoupper(Str::random(6));
        }

        return $this->supplierRepository->create($data);
    }

    public function updateSupplier(int $id, array $data): bool
    {
        return $this->supplierRepository->update($id, $data);
    }

    public function deleteSupplier(int $id): bool
    {
        return $this->supplierRepository->delete($id);
    }
}
