<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Services\SupplierService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SupplierController extends Controller
{
    public function __construct(
        protected SupplierService $supplierService
    ) {}

    public function index(Request $request): View
    {
        $filters = $request->only(['search']);
        $suppliers = $this->supplierService->getPaginatedSuppliers($filters, 5);

        return view('pages.inventory.suppliers.index', compact('suppliers', 'filters'));
    }

    public function create(): View
    {
        return view('pages.inventory.suppliers.create');
    }

    public function store(StoreSupplierRequest $request): RedirectResponse
    {
        $supplier = $this->supplierService->createSupplier($request->validated());

        return redirect()
            ->route('suppliers.index')
            ->with('success', "Supplier '{$supplier->name}' berhasil ditambahkan.");
    }

    public function edit(int $id): View
    {
        $supplier = $this->supplierService->getSupplierById($id);
        if (!$supplier) {
            abort(404, 'Supplier tidak ditemukan');
        }

        return view('pages.inventory.suppliers.edit', compact('supplier'));
    }

    public function update(UpdateSupplierRequest $request, int $id): RedirectResponse
    {
        $updated = $this->supplierService->updateSupplier($id, $request->validated());

        if (!$updated) {
            return back()->with('error', 'Gagal memperbarui data supplier.');
        }

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Data supplier berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $supplier = $this->supplierService->getSupplierById($id);
        if ($supplier && $supplier->products()->count() > 0) {
            return back()->with('error', "Gagal menghapus supplier '{$supplier->name}' karena masih terikat dengan produk.");
        }

        $deleted = $this->supplierService->deleteSupplier($id);

        if (!$deleted) {
            return back()->with('error', 'Gagal menghapus supplier.');
        }

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Supplier berhasil dihapus.');
    }
}
