<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Repositories\Contracts\SupplierRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SupplierController extends Controller
{
    public function __construct(
        protected SupplierRepositoryInterface $supplierRepository
    ) {}

    /**
     * Display a listing of available suppliers.
     */
    public function index(Request $request): View
    {
        $filters = $request->only(['search']);
        $suppliers = $this->supplierRepository->getAllPaginated($filters, 10);

        return view('pages.inventory.suppliers.index', compact('suppliers', 'filters'));
    }

    /**
     * Show the form for creating a new supplier (Admin).
     */
    public function create(): View
    {
        return view('pages.inventory.suppliers.create');
    }

    /**
     * Store a newly created supplier in storage (Admin).
     */
    public function store(StoreSupplierRequest $request): RedirectResponse
    {
        $supplier = $this->supplierRepository->create($request->validated());

        return redirect()
            ->route('suppliers.index')
            ->with('success', "Supplier '{$supplier->name}' ({$supplier->code}) berhasil ditambahkan.");
    }

    /**
     * Display details of a specific supplier.
     */
    public function show(int $id): View
    {
        $supplier = $this->supplierRepository->findById($id);
        if (!$supplier) {
            abort(404, 'Supplier tidak ditemukan.');
        }

        $supplier->load(['products.category', 'stockTransactions.product']);

        return view('pages.inventory.suppliers.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified supplier (Admin).
     */
    public function edit(int $id): View
    {
        $supplier = $this->supplierRepository->findById($id);
        if (!$supplier) {
            abort(404, 'Supplier tidak ditemukan.');
        }

        return view('pages.inventory.suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified supplier in storage (Admin).
     */
    public function update(UpdateSupplierRequest $request, int $id): RedirectResponse
    {
        $success = $this->supplierRepository->update($id, $request->validated());
        if (!$success) {
            return back()->withInput()->with('error', 'Gagal memperbarui supplier.');
        }

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Data supplier berhasil diperbarui.');
    }

    /**
     * Remove the specified supplier from storage (Admin).
     */
    public function destroy(int $id): RedirectResponse
    {
        $supplier = $this->supplierRepository->findById($id);
        if (!$supplier) {
            return back()->with('error', 'Supplier tidak ditemukan.');
        }

        // Check if supplier is referenced by products
        if ($supplier->products()->count() > 0) {
            return back()->with('error', "Supplier '{$supplier->name}' tidak dapat dihapus karena masih memiliki produk terikat.");
        }

        $this->supplierRepository->delete($id);

        return redirect()
            ->route('suppliers.index')
            ->with('success', "Supplier '{$supplier->name}' berhasil dihapus.");
    }
}
