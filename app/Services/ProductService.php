<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductService
{
    public function __construct(
        protected ProductRepositoryInterface $productRepository
    ) {}

    public function getPaginatedProducts(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return $this->productRepository->getAllPaginated($filters, $perPage);
    }

    public function getAllProducts(): Collection
    {
        return $this->productRepository->getAll();
    }

    public function getProductById(int $id): ?Product
    {
        return $this->productRepository->findById($id);
    }

    public function createProduct(array $data): Product
    {
        if (empty($data['sku'])) {
            $data['sku'] = 'PRD-' . strtoupper(Str::random(6));
        }

        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            $path = $data['image']->store('products', 'public');
            $data['image'] = $path;
        }

        $data['current_stock'] = $data['current_stock'] ?? 0;

        return $this->productRepository->create($data);
    }

    public function updateProduct(int $id, array $data): bool
    {
        $product = $this->productRepository->findById($id);
        if (!$product) {
            return false;
        }

        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $path = $data['image']->store('products', 'public');
            $data['image'] = $path;
        } else {
            unset($data['image']);
        }

        return $this->productRepository->update($id, $data);
    }

    public function deleteProduct(int $id): bool
    {
        $product = $this->productRepository->findById($id);
        if ($product && $product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
        return $this->productRepository->delete($id);
    }
}
