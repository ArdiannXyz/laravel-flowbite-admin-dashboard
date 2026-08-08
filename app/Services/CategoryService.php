<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    public function __construct(protected CategoryRepositoryInterface $categoryRepository)
    {
    }

    public function getAllCategories(): Collection
    {
        return $this->categoryRepository->getAll();
    }

    public function getPaginated(int $perPage = 15, ?string $search = null): LengthAwarePaginator
    {
        return $this->categoryRepository->paginate($perPage, $search);
    }

    public function getDetail(int $id): Category
    {
        return $this->categoryRepository->findOrFail($id);
    }

    public function createCategory(array $data): Category
    {
        return $this->categoryRepository->create($data);
    }

    public function updateCategory(int $id, array $data): Category
    {
        $category = $this->categoryRepository->findOrFail($id);
        return $this->categoryRepository->update($category, $data);
    }

    public function deleteCategory(int $id): bool
    {
        $category = $this->categoryRepository->findOrFail($id);
        return $this->categoryRepository->delete($category);
    }
}