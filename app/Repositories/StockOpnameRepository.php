<?php

namespace App\Repositories;

use App\Models\StockOpname;
use App\Repositories\Contracts\StockOpnameRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class StockOpnameRepository implements StockOpnameRepositoryInterface
{
    public function getAllPaginated(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = StockOpname::with(['product.category', 'user']);

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('opname_code', 'like', "%{$search}%")
                  ->orWhereHas('product', function ($pq) use ($search) {
                      $pq->where('name', 'like', "%{$search}%")
                         ->orWhere('sku', 'like', "%{$search}%");
                  });
            });
        }

        return $query->latest('id')->paginate($perPage)->withQueryString();
    }

    public function getRecentOpnames(int $limit = 5): Collection
    {
        return StockOpname::with(['product', 'user'])
            ->latest('id')
            ->take($limit)
            ->get();
    }

    public function create(array $data): StockOpname
    {
        return StockOpname::create($data);
    }

    public function findById(int $id): ?StockOpname
    {
        return StockOpname::with(['product', 'user'])->find($id);
    }
}
