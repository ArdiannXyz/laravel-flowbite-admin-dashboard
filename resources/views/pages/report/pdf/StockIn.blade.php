<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Barang Masuk</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #1f2937; }
        h1 { font-size: 18px; margin-bottom: 2px; }
        p.subtitle { margin-top: 0; color: #6b7280; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { border: 1px solid #d1d5db; padding: 6px 8px; text-align: left; }
        th { background-color: #f3f4f6; text-transform: uppercase; font-size: 10px; }
        td.right { text-align: right; color: #065f46; font-weight: bold; }
        .footer { margin-top: 20px; font-size: 10px; color: #9ca3af; }
    </style>
</head>
<body>
    <h1>Laporan Barang Masuk</h1>
    <p class="subtitle">Stockify &middot; Dicetak pada {{ $tanggalCetak }}</p>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>SKU</th>
                <th>Nama Produk</th>
                <th class="right">Qty</th>
                <th>Supplier</th>
                <th>Dicatat Oleh</th>
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
                </tr>
            @empty
                <tr>
                    <td colspan="6">Tidak ada riwayat barang masuk pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p class="footer">Total {{ $transaksi->count() }} transaksi &middot; Dokumen ini dibuat otomatis oleh sistem Stockify.</p>
</body>
</html>