<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct(protected CategoryService $categoryService)
    {
    }

    public function index(Request $request): View
    {
        $categories = $this->categoryService->getPaginated(15, $request->get('search'));
        return view('pages.inventory.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('pages.inventory.categories.create');
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        $this->categoryService->createCategory($request->validated());
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(int $id): View
    {
        $category = $this->categoryService->getDetail($id);
        return view('pages.inventory.categories.edit', compact('category'));
    }

    public function update(CategoryRequest $request, int $id): RedirectResponse
    {
        $this->categoryService->updateCategory($id, $request->validated());
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->categoryService->deleteCategory($id);
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}