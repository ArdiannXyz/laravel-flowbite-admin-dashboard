<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Supplier;

interface SupplierRepositoryInterface
{
    public function getAllPaginated(array $filters = [], int $perPage = 10): LengthAwarePaginator;
    public function getAll(): Collection;
    public function findById(int $id): ?Supplier;
    public function create(array $data): Supplier;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}
