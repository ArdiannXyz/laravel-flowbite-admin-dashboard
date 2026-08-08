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
        $products = $this->productService->getPaginatedProducts($filters, 10);
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

    public function import(): View
    {
        return view('pages.inventory.products.import');
    }

    public function storeImport(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xlsx|max:5048',
        ]);

        $file = $request->file('file');
        $handle = fopen($file->getRealPath(), 'r');
        $header = fgetcsv($handle, 1000, ',');
        $imported = 0;

        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            if (count($data) >= 4) {
                \App\Models\Product::updateOrCreate(
                    ['sku' => trim($data[0])],
                    [
                        'name' => trim($data[1]),
                        'buy_price' => (float) trim($data[2]),
                        'sell_price' => (float) trim($data[3]),
                        'current_stock' => isset($data[4]) ? (int) trim($data[4]) : 0,
                        'min_stock' => isset($data[5]) ? (int) trim($data[5]) : 5,
                        'unit' => isset($data[6]) ? trim($data[6]) : 'unit',
                    ]
                );
                $imported++;
            }
        }
        fclose($handle);

        return redirect()->route('products.index')->with('success', "Berhasil mengimpor {$imported} data produk.");
    }

    public function export()
    {
        $products = \App\Models\Product::with(['category', 'supplier'])->get();
        $filename = 'export-produk-' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($products) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['SKU', 'Nama Produk', 'Harga Beli', 'Harga Jual', 'Stok Saat Ini', 'Stok Minimum', 'Satuan', 'Kategori', 'Supplier']);

            foreach ($products as $p) {
                fputcsv($file, [
                    $p->sku,
                    $p->name,
                    $p->buy_price,
                    $p->sell_price,
                    $p->current_stock,
                    $p->min_stock,
                    $p->unit,
                    $p->category->name ?? '-',
                    $p->supplier->name ?? '-',
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
