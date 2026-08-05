<?php

namespace App\Repositories\Contracts;

use App\Models\StockTransaction;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface StockTransactionRepositoryInterface
{
    public function getByTypePaginated(string $type, array $filters = [], int $perPage = 10): LengthAwarePaginator;
    public function getAllPaginated(array $filters = [], int $perPage = 10, string $pageName = 'page'): LengthAwarePaginator;
    public function getRecentTransactions(int $limit = 5): Collection;
    public function countTodayTransactionsByType(string $type): int;
    public function sumTodayQuantityByType(string $type): int;
    public function create(array $data): StockTransaction;
    public function findById(int $id): ?StockTransaction;
}
