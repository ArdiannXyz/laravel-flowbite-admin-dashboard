<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAllPaginated(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = Product::with(['category', 'supplier']);

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (isset($filters['low_stock']) && $filters['low_stock']) {
            $query->whereColumn('current_stock', '<=', 'min_stock');
        }

        return $query->latest()->paginate($perPage)->withQueryString();
    }

    public function getAll(): Collection
    {
        return Product::with(['category', 'supplier'])->orderBy('name')->get();
    }

    public function findById(int $id): ?Product
    {
        return Product::with(['category', 'supplier', 'stockTransactions.user', 'stockOpnames.user'])->find($id);
    }

    public function findBySku(string $sku): ?Product
    {
        return Product::where('sku', $sku)->first();
    }

    public function getLowStockProducts(): Collection
    {
        return Product::with('category')
            ->whereColumn('current_stock', '<=', 'min_stock')
            ->orderBy('current_stock', 'asc')
            ->get();
    }

    public function countTotalProducts(): int
    {
        return Product::count();
    }

    public function countLowStockProducts(): int
    {
        return Product::whereColumn('current_stock', '<=', 'min_stock')->count();
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $product = Product::find($id);
        if (!$product) {
            return false;
        }
        return $product->update($data);
    }

    public function updateStock(int $id, int $newStock): bool
    {
        $product = Product::find($id);
        if (!$product) {
            return false;
        }
        return $product->update(['current_stock' => $newStock]);
    }

    public function delete(int $id): bool
    {
        $product = Product::find($id);
        if (!$product) {
            return false;
        }
        return $product->delete();
    }

    public function calculateTotalStockValue(): float
    {
        return (float) Product::sum(\Illuminate\Support\Facades\DB::raw('current_stock * buy_price'));
    }
}