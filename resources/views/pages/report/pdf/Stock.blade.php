<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Stok</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #1f2937; }
        h1 { font-size: 18px; margin-bottom: 2px; }
        p.subtitle { margin-top: 0; color: #6b7280; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { border: 1px solid #d1d5db; padding: 6px 8px; text-align: left; }
        th { background-color: #f3f4f6; text-transform: uppercase; font-size: 10px; }
        td.right { text-align: right; }
        .badge { padding: 2px 6px; border-radius: 3px; font-size: 10px; font-weight: bold; }
        .badge-aman { background-color: #d1fae5; color: #065f46; }
        .badge-menipis { background-color: #fee2e2; color: #991b1b; }
        .footer { margin-top: 20px; font-size: 10px; color: #9ca3af; }
    </style>
</head>
<body>
    <h1>Laporan Stok Barang</h1>
    <p class="subtitle">Stockify &middot; Dicetak pada {{ $tanggalCetak }}</p>

    <table>
        <thead>
            <tr>
                <th>SKU</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th class="right">Stok Saat Ini</th>
                <th class="right">Stok Minimum</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($stok as $item)
                <tr>
                    <td>{{ $item->sku }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->category->name ?? '-' }}</td>
                    <td class="right">{{ $item->current_stock }} {{ $item->unit ?? '' }}</td>
                    <td class="right">{{ $item->min_stock }} {{ $item->unit ?? '' }}</td>
                    <td>
                        <span class="badge {{ $item->current_stock < $item->min_stock ? 'badge-menipis' : 'badge-aman' }}">
                            {{ $item->current_stock < $item->min_stock ? 'Menipis' : 'Aman' }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Tidak ada data produk.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p class="footer">Total {{ $stok->count() }} produk &middot; Dokumen ini dibuat otomatis oleh sistem Stockify.</p>
</body>
</html>