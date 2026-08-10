<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductService
{
    public function __construct(
        protected ProductRepositoryInterface $productRepository,
        protected CategoryRepositoryInterface $categoryRepository
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
            $data['sku'] = $this->generateSku((int) $data['category_id']);
        }

        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            $path = $data['image']->store('products', 'public');
            $data['image'] = $path;
        }

        $data['current_stock'] = $data['current_stock'] ?? 0;

        return $this->productRepository->create($data);
    }

    /**
     * Generate SKU otomatis dengan format: PRD-[KODE KATEGORI]-[NOMOR URUT]
     * Contoh: PRD-ELK-001, PRD-ELK-002, dst.
     */
    protected function generateSku(int $categoryId): string
    {
        $category = $this->categoryRepository->findOrFail($categoryId);

        $categoryCode = strtoupper(
            substr(preg_replace('/[^A-Za-z]/', '', $category->name), 0, 3)
        );
        $categoryCode = $categoryCode ?: 'GEN';

        $lastSku = Product::where('sku', 'like', "PRD-{$categoryCode}-%")
            ->orderByDesc('id')
            ->value('sku');

        $nextNumber = 1;
        if ($lastSku && preg_match('/-(\d+)$/', $lastSku, $matches)) {
            $nextNumber = ((int) $matches[1]) + 1;
        }

        $sku = sprintf('PRD-%s-%03d', $categoryCode, $nextNumber);

        // Jaga-jaga kalau ada race condition / SKU sudah dipakai
        while (Product::where('sku', $sku)->exists()) {
            $nextNumber++;
            $sku = sprintf('PRD-%s-%03d', $categoryCode, $nextNumber);
        }

        return $sku;
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