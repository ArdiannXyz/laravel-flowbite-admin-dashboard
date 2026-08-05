<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct(
        protected ReportService $reportService
    ) {}

    public function index(Request $request)
    {
        $data = $this->reportService->getReportData($request);

        return view('pages.report.index', $data);
    }

    public function exportExcel(Request $request)
    {
        $type = $request->get('type', 'stok');
        $filename = "laporan-{$type}-" . date('Y-m-d') . ".csv";

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($type, $request) {
            $file = fopen('php://output', 'w');
            // Write UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            if ($type === 'stok') {
                fputcsv($file, ['SKU', 'Nama Produk', 'Kategori', 'Stok Saat Ini', 'Stok Minimum', 'Satuan', 'Harga Beli (Rp)', 'Harga Jual (Rp)', 'Total Nilai (Rp)', 'Status']);
                $products = $this->reportService->getStokProductsForExport($request);
                foreach ($products as $p) {
                    $status = ($p->current_stock < $p->min_stock) ? 'Menipis' : 'Aman';
                    fputcsv($file, [
                        $p->sku,
                        $p->name,
                        $p->category->name ?? '-',
                        $p->current_stock,
                        $p->min_stock,
                        $p->unit,
                        $p->buy_price,
                        $p->sell_price,
                        $p->current_stock * $p->buy_price,
                        $status,
                    ]);
                }
            } elseif ($type === 'masuk') {
                fputcsv($file, ['Tanggal', 'Kode Transaksi', 'SKU', 'Nama Produk', 'Jumlah', 'Supplier', 'Dicatat Oleh', 'Catatan']);
                $items = $this->reportService->getBarangMasukForExport($request);
                foreach ($items as $item) {
                    fputcsv($file, [
                        $item->transaction_date,
                        $item->transaction_code,
                        $item->product->sku ?? '-',
                        $item->product->name ?? '-',
                        $item->quantity,
                        $item->supplier->name ?? '-',
                        $item->user->name ?? 'System',
                        $item->notes ?? '-',
                    ]);
                }
            } elseif ($type === 'keluar') {
                fputcsv($file, ['Tanggal', 'Kode Transaksi', 'SKU', 'Nama Produk', 'Jumlah', 'Dicatat Oleh', 'Catatan']);
                $items = $this->reportService->getBarangKeluarForExport($request);
                foreach ($items as $item) {
                    fputcsv($file, [
                        $item->transaction_date,
                        $item->transaction_code,
                        $item->product->sku ?? '-',
                        $item->product->name ?? '-',
                        $item->quantity,
                        $item->user->name ?? 'System',
                        $item->notes ?? '-',
                    ]);
                }
            } elseif ($type === 'aktivitas') {
                fputcsv($file, ['Waktu', 'Kode Transaksi', 'Pengguna', 'Tipe', 'Produk', 'Jumlah', 'Catatan']);
                $items = $this->reportService->getAktivitasForExport($request);
                foreach ($items as $item) {
                    $tipe = $item->type === 'in' ? 'Barang Masuk' : 'Barang Keluar';
                    fputcsv($file, [
                        $item->created_at,
                        $item->transaction_code,
                        $item->user->name ?? 'System',
                        $tipe,
                        $item->product->name ?? '-',
                        $item->quantity,
                        $item->notes ?? '-',
                    ]);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf(Request $request)
    {
        $type = $request->get('type', 'stok');

        $data = [
            'type' => $type,
            'title' => match ($type) {
                'masuk'     => 'Laporan Barang Masuk',
                'keluar'    => 'Laporan Barang Keluar',
                'aktivitas' => 'Laporan Aktivitas Pengguna',
                default     => 'Laporan Stok Barang',
            },
            'generated_at' => date('d M Y H:i'),
        ];

        if ($type === 'stok') {
            $data['items'] = $this->reportService->getStokProductsForExport($request);
        } elseif ($type === 'masuk') {
            $data['items'] = $this->reportService->getBarangMasukForExport($request);
        } elseif ($type === 'keluar') {
            $data['items'] = $this->reportService->getBarangKeluarForExport($request);
        } elseif ($type === 'aktivitas') {
            $data['items'] = $this->reportService->getAktivitasForExport($request);
        }

        return view('pages.report.pdf', $data);
    }
}