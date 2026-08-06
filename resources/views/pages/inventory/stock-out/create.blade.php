@extends('layouts.dashboard')

@section('content')
<div class="px-4 pt-6">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Form Pengeluaran Barang (Barang Keluar)</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Pencatatan barang keluar akan otomatis mengurangi kuantitas stok produk.</p>
        </div>
        <a href="{{ route('stock-out.index') }}" class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">
            ← Kembali
        </a>
    </div>

    @if(session('error'))
        <div class="mb-6 flex items-center rounded-lg bg-red-50 p-4 text-sm text-red-800 dark:bg-gray-800 dark:text-red-400" role="alert">
            <svg class="mr-3 inline h-4 w-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.707a1 1 0 0 1-1.414 0L10 10.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 9 6.293 6.707a1 1 0 0 1 1.414-1.414L10 7.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 9l2.293 2.293a1 1 0 0 1 0 1.414Z"/></svg>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    <div class="max-w-3xl rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <form action="{{ route('stock-out.store') }}" method="POST" id="stock_out_form">
            @csrf
            <div class="space-y-6">
                <!-- Produk -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Pilih Produk <span class="text-red-500">*</span></label>
                    <select name="product_id" id="product_select" required class="w-full rounded-lg border border-gray-300 bg-gray-50 p-3 text-sm text-gray-900 focus:border-red-500 focus:ring-red-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <option value="">-- Pilih Produk --</option>
                        @foreach($products as $p)
                            <option value="{{ $p->id }}" 
                                    data-stock="{{ $p->current_stock }}" 
                                    data-unit="{{ $p->unit }}"
                                    {{ (old('product_id') ?? $selectedProductId) == $p->id ? 'selected' : '' }}>
                                {{ $p->name }} (SKU: {{ $p->sku }} | Stok Tersedia: {{ $p->current_stock }} {{ $p->unit }})
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <div id="stock_info_badge" class="mt-2.5 hidden rounded-lg bg-red-50 p-3 text-xs font-semibold text-red-800 dark:bg-red-900/40 dark:text-red-300"></div>
                </div>

                <!-- Jumlah & Harga -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Jumlah Barang Keluar <span class="text-red-500">*</span></label>
                        <input type="number" min="1" name="quantity" id="quantity_input" value="{{ old('quantity', 1) }}" required class="w-full rounded-lg border border-gray-300 bg-gray-50 p-3 text-sm text-gray-900 focus:border-red-500 focus:ring-red-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <div id="quantity_warning" class="mt-1.5 text-xs text-gray-500 dark:text-gray-400"></div>
                        @error('quantity')
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Harga Jual Per Satuan (Rp)</label>
                        <input type="number" step="0.01" name="unit_price" value="{{ old('unit_price') }}" placeholder="Default harga jual produk" class="w-full rounded-lg border border-gray-300 bg-gray-50 p-3 text-sm text-gray-900 focus:border-red-500 focus:ring-red-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    </div>
                </div>

                <!-- Tanggal Transaksi -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Tanggal Pengeluaran <span class="text-red-500">*</span></label>
                    <input type="date" name="transaction_date" value="{{ old('transaction_date', date('Y-m-d')) }}" required class="w-full rounded-lg border border-gray-300 bg-gray-50 p-3 text-sm text-gray-900 focus:border-red-500 focus:ring-red-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                </div>

                <!-- Catatan -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Catatan / Tujuan Pengiriman</label>
                    <textarea name="notes" rows="3" placeholder="Contoh: Penjualan ke Customer PT Maju Bersama / Ref Invoice #INV-1092" class="w-full rounded-lg border border-gray-300 bg-gray-50 p-3 text-sm text-gray-900 focus:border-red-500 focus:ring-red-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">{{ old('notes') }}</textarea>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t dark:border-gray-700">
                    <a href="{{ route('stock-out.index') }}" class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">
                        Batal
                    </a>
                    <button type="submit" id="submit_btn" class="rounded-lg bg-red-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 dark:focus:ring-red-800">
                        Simpan & Kurangi Stok
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const productSelect = document.getElementById('product_select');
    const quantityInput = document.getElementById('quantity_input');
    const stockBadge = document.getElementById('stock_info_badge');
    const quantityWarning = document.getElementById('quantity_warning');
    const submitBtn = document.getElementById('submit_btn');
    const form = document.getElementById('stock_out_form');

    function updateStockLimits() {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        if (!selectedOption || !selectedOption.value) {
            stockBadge.classList.add('hidden');
            quantityInput.removeAttribute('max');
            quantityWarning.innerHTML = '';
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            return;
        }

        const stock = parseInt(selectedOption.getAttribute('data-stock')) || 0;
        const unit = selectedOption.getAttribute('data-unit') || 'unit';

        quantityInput.setAttribute('max', stock);

        // Update Stock Info Badge
        stockBadge.classList.remove('hidden');

        validateQuantity(stock, unit);
    }

    function validateQuantity(stock, unit) {
        if (!productSelect.value) return;

        const val = parseInt(quantityInput.value) || 0;

        if (val > stock) {
            quantityInput.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
            quantityInput.classList.remove('border-gray-300', 'focus:border-blue-500');
            quantityWarning.className = 'mt-1.5 text-xs font-semibold text-red-600 dark:text-red-400';
            quantityWarning.innerHTML = `⚠️ Jumlah barang keluar (${val} ${unit}) melebihi total stok yang tersedia (Maksimal: ${stock} ${unit})!`;
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
        } else if (val <= 0) {
            quantityInput.classList.add('border-red-500');
            quantityWarning.className = 'mt-1.5 text-xs text-red-600';
            quantityWarning.innerHTML = `⚠️ Jumlah barang keluar harus minimal 1.`;
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
        } else {
            quantityInput.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
            quantityInput.classList.add('border-gray-300', 'focus:border-blue-500');
            const remaining = stock - val;
            quantityWarning.className = 'mt-1.5 text-xs font-medium text-green-600 dark:text-green-400';
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    }

    productSelect.addEventListener('change', updateStockLimits);
    quantityInput.addEventListener('input', updateStockLimits);

    form.addEventListener('submit', function(e) {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        if (selectedOption && selectedOption.value) {
            const stock = parseInt(selectedOption.getAttribute('data-stock')) || 0;
            const val = parseInt(quantityInput.value) || 0;
            if (val > stock) {
                e.preventDefault();
                alert(`Error: Jumlah barang keluar (${val}) melebihi stok yang tersedia (${stock})!`);
            }
        }
    });

    // Run on load
    updateStockLimits();
});
</script>
@endsection
