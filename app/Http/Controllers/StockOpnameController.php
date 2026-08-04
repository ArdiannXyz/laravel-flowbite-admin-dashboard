<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStockOpnameRequest;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Services\StockOpnameService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Exception;

class StockOpnameController extends Controller
{
    public function __construct(
        protected StockOpnameService $stockOpnameService,
        protected ProductRepositoryInterface $productRepository
    ) {}

    public function index(Request $request): View
    {
        $filters = $request->only(['search']);
        $opnames = $this->stockOpnameService->getPaginatedStockOpnames($filters, 10);

        return view('pages.inventory.stock-opname.index', compact('opnames', 'filters'));
    }

    public function create(Request $request): View
    {
        $products = $this->productRepository->getAll();
        $selectedProductId = $request->query('product_id');

        return view('pages.inventory.stock-opname.create', compact('products', 'selectedProductId'));
    }

    public function store(StoreStockOpnameRequest $request): RedirectResponse
    {
        try {
            $userId = Auth::id();
            $opname = $this->stockOpnameService->recordStockOpname($request->validated(), $userId);

            return redirect()
                ->route('stock-opname.index')
                ->with('success', "Stock Opname ({$opname->opname_code}) berhasil disimpan dan stok produk telah diperbarui menjadi {$opname->physical_stock}.");
        } catch (Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }
}
