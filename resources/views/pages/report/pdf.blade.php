<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - Stockify Inventory System</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 20px;
            background-color: #fff;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .header-title h1 {
            margin: 0;
            font-size: 20px;
            color: #1e293b;
        }
        .header-title p {
            margin: 4px 0 0 0;
            color: #64748b;
            font-size: 11px;
        }
        .meta-info {
            text-align: right;
            font-size: 11px;
            color: #475569;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #cbd5e1;
            padding: 8px 10px;
            text-align: left;
        }
        th {
            background-color: #f1f5f9;
            color: #1e293b;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 10px;
        }
        tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
        }
        .badge-green { background-color: #dcfce7; color: #166534; }
        .badge-red { background-color: #fee2e2; color: #991b1b; }
        .footer {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            color: #64748b;
        }
        .signature-box {
            text-align: center;
            width: 200px;
        }
        .signature-space {
            height: 50px;
        }
        @media print {
            body { margin: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="no-print" style="margin-bottom: 15px; text-align: right;">
        <button onclick="window.print()" style="background-color: #2563eb; color: #fff; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-weight: bold;">
            Cetak / Download PDF
        </button>
        <button onclick="window.close()" style="background-color: #64748b; color: #fff; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; margin-left: 8px;">
            Tutup
        </button>
    </div>

    <div class="header">
        <div class="header-title">
            <h1>Stockify Inventory System</h1>
            <p>{{ $title }}</p>
        </div>
        <div class="meta-info">
            <p><strong>Tanggal Cetak:</strong> {{ $generated_at }}</p>
            <p><strong>Total Item:</strong> {{ count($items) }}</p>
        </div>
    </div>

    @if($type === 'stok')
        <table>
            <thead>
                <tr>
                    <th>SKU</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th class="text-right">Stok Saat Ini</th>
                    <th class="text-right">Stok Min</th>
                    <th class="text-right">Harga Beli</th>
                    <th class="text-right">Total Nilai</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $p)
                    <tr>
                        <td>{{ $p->sku }}</td>
                        <td>{{ $p->name }}</td>
                        <td>{{ $p->category->name ?? '-' }}</td>
                        <td class="text-right">{{ $p->current_stock }} {{ $p->unit }}</td>
                        <td class="text-right">{{ $p->min_stock }} {{ $p->unit }}</td>
                        <td class="text-right">Rp {{ number_format($p->buy_price, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($p->current_stock * $p->buy_price, 0, ',', '.') }}</td>
                        <td class="text-center">
                            @if($p->current_stock < $p->min_stock)
                                <span class="badge badge-red">Menipis</span>
                            @else
                                <span class="badge badge-green">Aman</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center">Tidak ada data.</td></tr>
                @endforelse
            </tbody>
        </table>

    @elseif($type === 'masuk')
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Kode Transaksi</th>
                    <th>SKU</th>
                    <th>Nama Produk</th>
                    <th class="text-right">Qty</th>
                    <th>Supplier</th>
                    <th>Dicatat Oleh</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($item->transaction_date)->format('d/m/Y') }}</td>
                        <td>{{ $item->transaction_code }}</td>
                        <td>{{ $item->product->sku ?? '-' }}</td>
                        <td>{{ $item->product->name ?? '-' }}</td>
                        <td class="text-right" style="color: #166534; font-weight: bold;">+{{ $item->quantity }}</td>
                        <td>{{ $item->supplier->name ?? '-' }}</td>
                        <td>{{ $item->user->name ?? 'System' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center">Tidak ada data.</td></tr>
                @endforelse
            </tbody>
        </table>

    @elseif($type === 'keluar')
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Kode Transaksi</th>
                    <th>SKU</th>
                    <th>Nama Produk</th>
                    <th class="text-right">Qty</th>
                    <th>Dicatat Oleh</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($item->transaction_date)->format('d/m/Y') }}</td>
                        <td>{{ $item->transaction_code }}</td>
                        <td>{{ $item->product->sku ?? '-' }}</td>
                        <td>{{ $item->product->name ?? '-' }}</td>
                        <td class="text-right" style="color: #991b1b; font-weight: bold;">-{{ $item->quantity }}</td>
                        <td>{{ $item->user->name ?? 'System' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center">Tidak ada data.</td></tr>
                @endforelse
            </tbody>
        </table>

    @elseif($type === 'aktivitas')
        <table>
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>Kode Transaksi</th>
                    <th>Pengguna</th>
                    <th>Tipe</th>
                    <th>Produk</th>
                    <th class="text-right">Qty</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i') }}</td>
                        <td>{{ $item->transaction_code }}</td>
                        <td>{{ $item->user->name ?? 'System' }}</td>
                        <td>{{ $item->type === 'in' ? 'Barang Masuk' : 'Barang Keluar' }}</td>
                        <td>{{ $item->product->name ?? '-' }}</td>
                        <td class="text-right">{{ $item->quantity }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center">Tidak ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    @endif

    <div class="footer">
        <div>Dokumen ini dihasilkan secara otomatis oleh Stockify Inventory System.</div>
        <div class="signature-box">
            <p>Petugas Gudang,</p>
            <div class="signature-space"></div>
            <p>( ____________________ )</p>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
