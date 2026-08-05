<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StockInExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $transaksi;

    public function __construct($transaksi)
    {
        $this->transaksi = $transaksi;
    }

    public function collection()
    {
        return $this->transaksi;
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'SKU',
            'Nama Produk',
            'Qty',
            'Supplier',
            'Dicatat Oleh',
        ];
    }

    public function map($item): array
    {
        return [
            \Carbon\Carbon::parse($item->transaction_date)->format('d/m/Y'),
            $item->product->sku ?? '-',
            $item->product->name ?? 'N/A',
            $item->quantity,
            $item->supplier->name ?? '-',
            $item->user->name ?? 'System',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}