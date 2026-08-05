<?php

namespace App\Repositories\Contracts;

use App\Models\StockOpname;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface StockOpnameRepositoryInterface
{
    public function getAllPaginated(array $filters = [], int $perPage = 10): LengthAwarePaginator;
    public function getRecentOpnames(int $limit = 5): Collection;
    public function create(array $data): StockOpname;
    public function findById(int $id): ?StockOpname;
}
