@extends('layouts.dashboard')

@section('content')
<div class="px-4 pt-6">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Form Stock Opname (Pemeriksaan Fisik Stok)</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Pencatatan hasil hitung fisik barang. Stok di sistem akan disesuaikan secara otomatis sesuai hasil opname.</p>
        </div>
        <a href="{{ route('stock-opname.index') }}" class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">
            ← Kembali
        </a>
    </div>

    @if(session('error'))
        <div class="mb-6 rounded-lg bg-red-50 p-4 text-sm text-red-800 dark:bg-gray-800 dark:text-red-400">
            {{ session('error') }}
        </div>
    @endif

    <div class="max-w-3xl rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <form action="{{ route('stock-opname.store') }}" method="POST" id="stock_opname_form">
            @csrf
            <div class="space-y-6">
                <!-- Pilih Produk -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Pilih Produk <span class="text-red-500">*</span></label>
                    <select name="product_id" id="product_select" required class="w-full rounded-lg border border-gray-300 bg-gray-50 p-3 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <option value="">-- Pilih Produk yang Diperiksa --</option>
                        @foreach($products as $p)
                            <option value="{{ $p->id }}" 
                                    data-stock="{{ $p->current_stock }}" 
                                    data-unit="{{ $p->unit }}"
                                    {{ (old('product_id') ?? $selectedProductId) == $p->id ? 'selected' : '' }}>
                                {{ $p->name }} (SKU: {{ $p->sku }} | Stok Sistem: {{ $p->current_stock }} {{ $p->unit }})
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <div id="stock_info_badge" class="mt-2.5 hidden rounded-lg bg-blue-50 p-3 text-xs font-semibold text-blue-800 dark:bg-blue-900/40 dark:text-blue-300"></div>
                </div>

                <!-- Input Stok Fisik -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Hasil Penghitungan Stok Fisik <span class="text-red-500">*</span></label>
                    <input type="number" min="0" name="physical_stock" id="physical_stock_input" value="{{ old('physical_stock', 0) }}" required placeholder="Jumlah riil di lokasi gudang" class="w-full rounded-lg border border-gray-300 bg-gray-50 p-3 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    <div id="opname_warning" class="mt-1.5 text-xs text-gray-500 dark:text-gray-400"></div>
                    @error('physical_stock')
                        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Opname -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Tanggal Audit Opname <span class="text-red-500">*</span></label>
                    <input type="date" name="opname_date" value="{{ old('opname_date', date('Y-m-d')) }}" required class="w-full rounded-lg border border-gray-300 bg-gray-50 p-3 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                </div>

                <!-- Catatan / Alasan Selisih -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Alasan Selisih / Catatan Audit</label>
                    <textarea name="notes" rows="3" placeholder="Contoh: Terjadi kerusakan fisik barang 2 unit / Salah pencatatan sebelumnya" class="w-full rounded-lg border border-gray-300 bg-gray-50 p-3 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">{{ old('notes') }}</textarea>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t dark:border-gray-700">
                    <a href="{{ route('stock-opname.index') }}" class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">
                        Batal
                    </a>
                    <button type="submit" id="submit_btn" class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800">
                        Simpan & Singkronkan Stok
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const productSelect = document.getElementById('product_select');
    const physicalInput = document.getElementById('physical_stock_input');
    const stockBadge = document.getElementById('stock_info_badge');
    const opnameWarning = document.getElementById('opname_warning');
    const submitBtn = document.getElementById('submit_btn');
    const form = document.getElementById('stock_opname_form');

    function updateOpnameLimits() {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        if (!selectedOption || !selectedOption.value) {
            stockBadge.classList.add('hidden');
            physicalInput.removeAttribute('max');
            opnameWarning.className = 'mt-1.5 text-xs text-gray-500 dark:text-gray-400';
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            return;
        }

        const stock = parseInt(selectedOption.getAttribute('data-stock')) || 0;
        const unit = selectedOption.getAttribute('data-unit') || 'unit';

        physicalInput.setAttribute('max', stock);

    
        validatePhysicalStock(stock, unit);
    }

    function validatePhysicalStock(stock, unit) {
        if (!productSelect.value) return;

        const val = parseInt(physicalInput.value);
        if (isNaN(val) || val < 0) {
            physicalInput.classList.add('border-red-500');
            opnameWarning.className = 'mt-1.5 text-xs text-red-600 dark:text-red-400';
            opnameWarning.innerHTML = `⚠️ Jumlah stok fisik tidak boleh negatif.`;
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            return;
        }

        if (val > stock) {
            physicalInput.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
            physicalInput.classList.remove('border-gray-300', 'focus:border-amber-500');
            opnameWarning.className = 'mt-1.5 text-xs font-semibold text-red-600 dark:text-red-400';
            opnameWarning.innerHTML = `⚠️ Jumlah stok fisik (${val} ${unit}) tidak boleh melebihi stok yang tercatat di sistem (Maksimal: ${stock} ${unit})!`;
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
        } else {
            physicalInput.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
            physicalInput.classList.add('border-gray-300', 'focus:border-amber-500');

            const diff = val - stock;
            if (diff === 0) {
                opnameWarning.className = 'mt-1.5 text-xs font-medium text-green-600 dark:text-green-400';
                
            } else {
                opnameWarning.className = 'mt-1.5 text-xs font-medium text-amber-600 dark:text-amber-400';
            }

            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    }

    productSelect.addEventListener('change', updateOpnameLimits);
    physicalInput.addEventListener('input', updateOpnameLimits);

    form.addEventListener('submit', function(e) {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        if (selectedOption && selectedOption.value) {
            const stock = parseInt(selectedOption.getAttribute('data-stock')) || 0;
            const val = parseInt(physicalInput.value);
            if (isNaN(val) || val > stock) {
                e.preventDefault();
                alert(`Error: Stok fisik (${val}) tidak boleh melebihi stok di sistem (${stock})!`);
            }
        }
    });

    // Run on load
    updateOpnameLimits();
});
</script>
@endsection
