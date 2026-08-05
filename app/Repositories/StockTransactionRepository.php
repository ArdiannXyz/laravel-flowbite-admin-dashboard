<?php

namespace App\Repositories;

use App\Models\StockTransaction;
use App\Repositories\Contracts\StockTransactionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

class StockTransactionRepository implements StockTransactionRepositoryInterface
{
    public function getByTypePaginated(string $type, array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = StockTransaction::with(['product.category', 'supplier', 'user'])
            ->where('type', $type);

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('transaction_code', 'like', "%{$search}%")
                  ->orWhereHas('product', function ($pq) use ($search) {
                      $pq->where('name', 'like', "%{$search}%")
                         ->orWhere('sku', 'like', "%{$search}%");
                  });
            });
        }

        if (!empty($filters['date_from'])) {
            $query->whereDate('transaction_date', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate('transaction_date', '<=', $filters['date_to']);
        }

        return $query->latest('id')->paginate($perPage)->withQueryString();
    }

    public function getAllPaginated(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = StockTransaction::with(['product.category', 'supplier', 'user']);

        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('transaction_code', 'like', "%{$search}%")
                  ->orWhereHas('product', function ($pq) use ($search) {
                      $pq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        return $query->latest('id')->paginate($perPage)->withQueryString();
    }

    public function getRecentTransactions(int $limit = 5): Collection
    {
        return StockTransaction::with(['product', 'supplier', 'user'])
            ->latest('id')
            ->take($limit)
            ->get();
    }

    public function countTodayTransactionsByType(string $type): int
    {
        return StockTransaction::where('type', $type)
            ->whereDate('transaction_date', Carbon::today())
            ->count();
    }

    public function sumTodayQuantityByType(string $type): int
    {
        return (int) StockTransaction::where('type', $type)
            ->whereDate('transaction_date', Carbon::today())
            ->sum('quantity');
    }

    public function create(array $data): StockTransaction
    {
        return StockTransaction::create($data);
    }

    public function findById(int $id): ?StockTransaction
    {
        return StockTransaction::with(['product', 'supplier', 'user'])->find($id);
    }

    public function getByTypeForExport(string $type, array $filters = [])
{
    $query = StockTransaction::with(['product', 'supplier', 'user'])
        ->where('type', $type);
 
    if (!empty($filters['date_from'])) {
        $query->whereDate('transaction_date', '>=', $filters['date_from']);
    }
 
    if (!empty($filters['date_to'])) {
        $query->whereDate('transaction_date', '<=', $filters['date_to']);
    }
 
    return $query->orderByDesc('transaction_date')->get();
}
 
public function getAllForExport(array $filters = [])
{
    $query = StockTransaction::with(['product', 'user']);
 
    if (!empty($filters['user_id'])) {
        $query->where('user_id', $filters['user_id']);
    }
 
    if (!empty($filters['date_from'])) {
        $query->whereDate('created_at', '>=', $filters['date_from']);
    }
 
    if (!empty($filters['date_to'])) {
        $query->whereDate('created_at', '<=', $filters['date_to']);
    }
 
    return $query->orderByDesc('created_at')->get();
}
}
