<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStockOutRequest;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Services\StockOutService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Exception;
use App\Models\StockTransaction;

class StockOutController extends Controller
{
    public function __construct(
        protected StockOutService $stockOutService,
        protected ProductRepositoryInterface $productRepository
    ) {}

    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'date_from', 'date_to']);
        $transactions = $this->stockOutService->getPaginatedStockOut($filters, 10);

        return view('pages.inventory.stock-out.index', compact('transactions', 'filters'));
    }

    public function create(Request $request): View
    {
        $products = $this->productRepository->getAll();
        $selectedProductId = $request->query('product_id');

        return view('pages.inventory.stock-out.create', compact('products', 'selectedProductId'));
    }

    public function store(StoreStockOutRequest $request): RedirectResponse
    {
        try {
            $userId = Auth::id();
            $transaction = $this->stockOutService->recordStockOut($request->validated(), $userId);

            return redirect()
                ->route('stock-out.index')
                ->with('success', "Transaksi Pengeluaran Barang ({$transaction->transaction_code}) berhasil dicatat. Stok berkurang {$transaction->quantity}.");
        } catch (Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function confirm(StockTransaction $stockTransaction): RedirectResponse
    {
        try {
            $this->stockOutService->confirmStockOut($stockTransaction, Auth::id());
            return back()->with('success', 'Barang keluar berhasil dikonfirmasi.');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function reject(Request $request, StockTransaction $stockTransaction)
    {
        // Validasi agar alasan wajib diisi
        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);

        // Update status menjadi rejected dan simpan alasannya
        $stockTransaction->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        return redirect()->back()->with('success', 'Transaksi berhasil ditolak.');
    }
}
