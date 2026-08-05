<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\SupplierRepositoryInterface;
use App\Services\ProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService,
        protected CategoryRepositoryInterface $categoryRepository,
        protected SupplierRepositoryInterface $supplierRepository
    ) {}

    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'category_id', 'low_stock']);
        $products = $this->productService->getPaginatedProducts($filters, 5);
        $categories = $this->categoryRepository->getAll();

        return view('pages.inventory.products.index', compact('products', 'categories', 'filters'));
    }

    public function create(): View
    {
        $categories = $this->categoryRepository->getAll();
        $suppliers = $this->supplierRepository->getAll();

        return view('pages.inventory.products.create', compact('categories', 'suppliers'));
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $product = $this->productService->createProduct($request->validated());

        return redirect()
            ->route('products.index')
            ->with('success', "Produk '{$product->name}' berhasil ditambahkan.");
    }

    public function show(int $id): View
    {
        $product = $this->productService->getProductById($id);
        if (!$product) {
            abort(404, 'Produk tidak ditemukan');
        }

        return view('pages.inventory.products.show', compact('product'));
    }

    public function edit(int $id): View
    {
        $product = $this->productService->getProductById($id);
        if (!$product) {
            abort(404, 'Produk tidak ditemukan');
        }

        $categories = $this->categoryRepository->getAll();
        $suppliers = $this->supplierRepository->getAll();

        return view('pages.inventory.products.edit', compact('product', 'categories', 'suppliers'));
    }

    public function update(UpdateProductRequest $request, int $id): RedirectResponse
    {
        $updated = $this->productService->updateProduct($id, $request->validated());

        if (!$updated) {
            return back()->with('error', 'Gagal memperbarui data produk.');
        }

        return redirect()
            ->route('products.index')
            ->with('success', 'Data produk berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $deleted = $this->productService->deleteProduct($id);

        if (!$deleted) {
            return back()->with('error', 'Gagal menghapus produk.');
        }

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
