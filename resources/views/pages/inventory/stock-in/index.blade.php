@extends('layouts.dashboard')

@section('content')
<div class="px-4 pt-6">
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Riwayat Barang Masuk</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Pencatatan transaksi penerimaan stok barang dari supplier.</p>
        </div>
        @hasanyrole('admin|manajer')
            <div>
                <a href="{{ route('stock-in.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-300 dark:focus:ring-green-800">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Input Penerimaan Barang
                </a>
            </div>
        @endhasanyrole
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-lg bg-green-50 p-4 text-sm text-green-800 dark:bg-gray-800 dark:text-green-400" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 rounded-lg bg-red-50 p-4 text-sm text-red-800 dark:bg-gray-800 dark:text-red-400" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <!-- Filter Form -->
    <div class="mb-4 rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <form method="GET" action="{{ route('stock-in.index') }}" class="flex flex-col gap-4 md:flex-row md:items-center">
            <div class="flex-1">
                <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Cari Kode TRX atau Nama Produk..." class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
            </div>
            <div class="flex items-center gap-2">
                <input type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}" class="rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                <span class="text-gray-500 dark:text-gray-400">s/d</span>
                <input type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}" class="rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
            </div>
            <div>
                <select name="status" class="rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ ($filters['status'] ?? '') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ ($filters['status'] ?? '') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="rejected" {{ ($filters['status'] ?? '') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div class="flex items-center gap-2">
                <button type="submit" class="rounded-lg bg-gray-800 px-4 py-2.5 text-sm font-medium text-white hover:bg-gray-900 dark:bg-gray-700 dark:hover:bg-gray-600">Filter</button>
                <a href="{{ route('stock-in.index') }}" class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">Refresh</a>
            </div>
        </form>
    </div>

    <!-- Transactions Table -->
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3">Kode Transaksi</th>
                        <th class="px-6 py-3">Nama Produk</th>
                        <th class="px-6 py-3">Supplier</th>
                        <th class="px-6 py-3 text-center">Jumlah Masuk</th>
                        <th class="px-6 py-3">Harga Satuan</th>
                        <th class="px-6 py-3">Catatan</th>
                        <th class="px-6 py-3 text-center">Status</th>
                        @role('staff')
                            <th class="px-6 py-3 text-center">Aksi</th>
                        @endrole
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($transactions as $trx)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4 text-xs font-medium text-gray-900 dark:text-white">
                                {{ $trx->transaction_date->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 font-mono text-xs font-semibold text-green-700 dark:text-green-400">
                                {{ $trx->transaction_code }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ $trx->product->name ?? '-' }}
                                <div class="text-xs font-normal text-gray-400">SKU: {{ $trx->product->sku ?? '' }}</div>
                            </td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                {{ $trx->supplier->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-center font-extrabold text-green-600 dark:text-green-400">
                                +{{ $trx->quantity }} {{ $trx->product->unit ?? '' }}
                            </td>
                            <td class="px-6 py-4 text-gray-900 dark:text-white">
                                Rp {{ number_format($trx->unit_price ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-500 dark:text-gray-400">
                                {{ $trx->notes ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $statusColor = match($trx->status) {
                                        'confirmed' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                                        'rejected'  => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                                        default     => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                                    };
                                @endphp
                                <span class="rounded-full px-2.5 py-0.5 text-xs font-medium {{ $statusColor }}">
                                    {{ ucfirst($trx->status) }}
                                </span>
                            </td>
                            @role('staff')
                                <td class="px-6 py-4 text-center">
                                    @if($trx->status === 'pending')
                                        <div class="flex justify-center gap-2">
                                            <!-- Tombol Konfirmasi -->
                                            <form action="{{ route('stock-in.confirm', $trx) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="rounded-lg bg-green-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-green-700">
                                                    Konfirmasi
                                                </button>
                                            </form>

                                            <!-- Form & Tombol Tolak dengan Input Alasan (Prompt) -->
                                            <form action="{{ route('stock-in.reject', $trx) }}" method="POST" id="reject-form-{{ $trx->id }}">
                                                @csrf
                                                <input type="hidden" name="rejection_reason" id="rejection_reason_{{ $trx->id }}">
                                                <button type="button" onclick="handleReject({{ $trx->id }})" class="rounded-lg bg-red-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-red-700">
                                                    Tolak
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-400">-</span>
                                    @endif
                                </td>
                            @endrole
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-8 text-center text-gray-500 dark:text-gray-400">Belum ada transaksi barang masuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-gray-200 p-4 dark:border-gray-700">
            {{ $transactions->appends($filters)->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Pastikan library SweetAlert2 sudah dimuat di layout utama Anda -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function handleReject(id) {
        Swal.fire({
            title: 'Tolak Transaksi?',
            text: "Silakan masukkan alasan penolakan barang masuk:",
            input: 'text',
            inputPlaceholder: 'Contoh: Barang tidak sesuai / rusak',
            showCancelButton: true,
            confirmButtonColor: '#dc2626', // Warna tombol tolak (Red-600)
            cancelButtonColor: '#6b7280',  // Warna tombol batal (Gray-500)
            confirmButtonText: 'Ya, Tolak',
            cancelButtonText: 'Batal',
            inputValidator: (value) => {
                if (!value || value.trim() === "") {
                    return 'Alasan penolakan wajib diisi!';
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Masukkan nilai input dari SweetAlert ke input hidden form
                document.getElementById('rejection_reason_' + id).value = result.value;
                
                // Submit form penolakan
                document.getElementById('reject-form-' + id).submit();
            }
        });
    }
</script>
@endpush