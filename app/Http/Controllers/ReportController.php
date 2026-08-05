<?php

namespace App\Http\Controllers;

use App\Exports\ActivityExport;
use App\Exports\StockExport;
use App\Exports\StockInExport;
use App\Exports\StockOutExport;
use App\Services\ReportService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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

    public function exportStokPdf(Request $request)
    {
        $stok = $this->reportService->exportStok($request);

        $pdf = Pdf::loadView('pages.report.pdf.Stock', [
            'stok' => $stok,
            'tanggalCetak' => now()->format('d F Y, H:i'),
        ])->setPaper('a4', 'portrait');

        return $pdf->download('laporan-stok-' . now()->format('Y-m-d') . '.pdf');
    }

    public function exportBarangMasukPdf(Request $request)
    {
        $transaksi = $this->reportService->exportBarangMasuk($request);

        $pdf = Pdf::loadView('pages.report.pdf.StockIn', [
            'transaksi' => $transaksi,
            'tanggalCetak' => now()->format('d F Y, H:i'),
        ])->setPaper('a4', 'portrait');

        return $pdf->download('laporan-barang-masuk-' . now()->format('Y-m-d') . '.pdf');
    }

    public function exportBarangKeluarPdf(Request $request)
    {
        $transaksi = $this->reportService->exportBarangKeluar($request);

        $pdf = Pdf::loadView('pages.report.pdf.StockOut', [
            'transaksi' => $transaksi,
            'tanggalCetak' => now()->format('d F Y, H:i'),
        ])->setPaper('a4', 'portrait');

        return $pdf->download('laporan-barang-keluar-' . now()->format('Y-m-d') . '.pdf');
    }

    public function exportAktivitasPdf(Request $request)
    {
        $aktivitas = $this->reportService->exportAktivitas($request);

        $pdf = Pdf::loadView('pages.report.pdf.Activity', [
            'aktivitas' => $aktivitas,
            'tanggalCetak' => now()->format('d F Y, H:i'),
        ])->setPaper('a4', 'portrait');

        return $pdf->download('laporan-aktivitas-' . now()->format('Y-m-d') . '.pdf');
    }

    public function exportStokExcel(Request $request)
    {
        $stok = $this->reportService->exportStok($request);

        return Excel::download(
            new StockExport($stok),
            'laporan-stok-' . now()->format('Y-m-d') . '.xlsx'
        );
    }

    public function exportBarangMasukExcel(Request $request)
    {
        $transaksi = $this->reportService->exportBarangMasuk($request);

        return Excel::download(
            new StockInExport($transaksi),
            'laporan-barang-masuk-' . now()->format('Y-m-d') . '.xlsx'
        );
    }

    public function exportBarangKeluarExcel(Request $request)
    {
        $transaksi = $this->reportService->exportBarangKeluar($request);

        return Excel::download(
            new StockOutExport($transaksi),
            'laporan-barang-keluar-' . now()->format('Y-m-d') . '.xlsx'
        );
    }

    public function exportAktivitasExcel(Request $request)
    {
        $aktivitas = $this->reportService->exportAktivitas($request);

        return Excel::download(
            new ActivityExport($aktivitas),
            'laporan-aktivitas-' . now()->format('Y-m-d') . '.xlsx'
        );
    }
}