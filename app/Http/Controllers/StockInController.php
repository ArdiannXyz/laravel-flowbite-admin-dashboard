<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStockInRequest;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\SupplierRepositoryInterface;
use App\Services\StockInService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Exception;

class StockInController extends Controller
{
    public function __construct(
        protected StockInService $stockInService,
        protected ProductRepositoryInterface $productRepository,
        protected SupplierRepositoryInterface $supplierRepository
    ) {}

    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'date_from', 'date_to']);
        $transactions = $this->stockInService->getPaginatedStockIn($filters, 5);

        return view('pages.inventory.stock-in.index', compact('transactions', 'filters'));
    }

    public function create(Request $request): View
    {
        $products = $this->productRepository->getAll();
        $suppliers = $this->supplierRepository->getAll();
        $selectedProductId = $request->query('product_id');

        return view('pages.inventory.stock-in.create', compact('products', 'suppliers', 'selectedProductId'));
    }

    public function store(StoreStockInRequest $request): RedirectResponse
    {
        try {
            $userId = Auth::id();
            $transaction = $this->stockInService->recordStockIn($request->validated(), $userId);

            return redirect()
                ->route('stock-in.index')
                ->with('success', "Transaksi Penerimaan Barang ({$transaction->transaction_code}) berhasil dicatat. Stok bertambah {$transaction->quantity}.");
        } catch (Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }
}
