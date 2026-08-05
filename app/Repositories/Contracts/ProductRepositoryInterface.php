<?php

namespace App\Repositories\Contracts;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface
{
    public function getAllPaginated(array $filters = [], int $perPage = 10): LengthAwarePaginator;
    public function getAll(): Collection;
    public function findById(int $id): ?Product;
    public function findBySku(string $sku): ?Product;
    public function getLowStockProducts(): Collection;
    public function countTotalProducts(): int;
    public function countLowStockProducts(): int;
    public function calculateTotalStockValue(): float;
    public function create(array $data): Product;
    public function update(int $id, array $data): bool;
    public function updateStock(int $id, int $newStock): bool;
    public function delete(int $id): bool;
    public function getAllForExport(array $filters = []);
}
