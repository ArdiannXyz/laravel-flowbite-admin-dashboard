<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Aktivitas Pengguna</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #1f2937; }
        h1 { font-size: 18px; margin-bottom: 2px; }
        p.subtitle { margin-top: 0; color: #6b7280; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { border: 1px solid #d1d5db; padding: 6px 8px; text-align: left; }
        th { background-color: #f3f4f6; text-transform: uppercase; font-size: 10px; }
        .badge { padding: 2px 6px; border-radius: 3px; font-size: 10px; font-weight: bold; }
        .badge-masuk { background-color: #dbeafe; color: #1e40af; }
        .badge-keluar { background-color: #ede9fe; color: #5b21b6; }
        .footer { margin-top: 20px; font-size: 10px; color: #9ca3af; }
    </style>
</head>
<body>
    <h1>Laporan Aktivitas Pengguna</h1>
    <p class="subtitle">Stockify &middot; Dicetak pada {{ $tanggalCetak }}</p>

    <table>
        <thead>
            <tr>
                <th>Waktu</th>
                <th>Pengguna</th>
                <th>Role</th>
                <th>Aktivitas</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($aktivitas as $log)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($log->created_at)->translatedFormat('d M Y, H:i') }}</td>
                    <td>{{ $log->user->name ?? 'System' }}</td>
                    <td>{{ ucfirst($log->user->role ?? '-') }}</td>
                    <td>
                        <span class="badge {{ $log->type === 'in' ? 'badge-masuk' : 'badge-keluar' }}">
                            {{ $log->type === 'in' ? 'Barang Masuk' : 'Barang Keluar' }}
                        </span>
                    </td>
                    <td>
                        Pencatatan {{ $log->type === 'in' ? 'penerimaan' : 'pengeluaran' }} {{ $log->product->name ?? 'barang' }} ({{ $log->quantity }} unit)
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Tidak ada catatan aktivitas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p class="footer">Total {{ $aktivitas->count() }} aktivitas &middot; Dokumen ini dibuat otomatis oleh sistem Stockify.</p>
</body>
</html>