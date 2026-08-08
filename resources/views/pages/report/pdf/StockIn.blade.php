<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Barang Masuk</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #1f2937; }
        h1 { font-size: 18px; margin-bottom: 2px; }
        p.subtitle { margin-top: 0; color: #6b7280; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; table-layout: fixed; }
        th, td { border: 1px solid #d1d5db; padding: 5px 6px; text-align: left; word-wrap: break-word; }
        th { background-color: #f3f4f6; text-transform: uppercase; font-size: 9px; }
        td.right { text-align: right; color: #065f46; font-weight: bold; }
        .badge-pending { color: #d97706; font-weight: bold; }
        .badge-confirmed { color: #059669; font-weight: bold; }
        .badge-rejected { color: #dc2626; font-weight: bold; }
        .footer { margin-top: 20px; font-size: 10px; color: #9ca3af; }
    </style>
</head>
<body>
    <h1>Laporan Barang Masuk</h1>
    <p class="subtitle">Stockify &middot; Dicetak pada {{ $tanggalCetak }}</p>

    <table>
        <thead>
            <tr>
                <th style="width: 12%;">Tanggal</th>
                <th style="width: 12%;">SKU</th>
                <th style="width: 18%;">Nama Produk</th>
                <th style="width: 8%;" class="right">Qty</th>
                <th style="width: 15%;">Supplier</th>
                <th style="width: 12%;">Dicatat Oleh</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 13%;">Alasan / Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksi as $item)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($item->transaction_date)->translatedFormat('d M Y') }}</td>
                    <td>{{ $item->product->sku ?? '-' }}</td>
                    <td>{{ $item->product->name ?? 'N/A' }}</td>
                    <td class="right">+{{ $item->quantity }}</td>
                    <td>{{ $item->supplier->name ?? '-' }}</td>
                    <td>{{ $item->user->name ?? 'System' }}</td>
                    <td>
                        @if($item->status == 'confirmed')
                            <span class="badge-confirmed">Confirmed</span>
                        @elseif($item->status == 'rejected')
                            <span class="badge-rejected">Rejected</span>
                        @else
                            <span class="badge-pending">Pending</span>
                        @endif
                    </td>
                    <td>{{ $item->rejection_reason ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">Tidak ada riwayat barang masuk pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p class="footer">Total {{ $transaksi->count() }} transaksi &middot; Dokumen ini dibuat otomatis oleh sistem Stockify.</p>
</body>
</html>