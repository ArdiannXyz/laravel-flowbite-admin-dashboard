<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StockExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $stok;

    public function __construct($stok)
    {
        $this->stok = $stok;
    }

    public function collection()
    {
        return $this->stok;
    }

    public function headings(): array
    {
        return [
            'SKU',
            'Nama Produk',
            'Kategori',
            'Stok Saat Ini',
            'Stok Minimum',
            'Status',
        ];
    }

    public function map($item): array
    {
        return [
            $item->sku,
            $item->name,
            $item->category->name ?? '-',
            $item->current_stock . ' ' . ($item->unit ?? ''),
            $item->min_stock . ' ' . ($item->unit ?? ''),
            $item->current_stock < $item->min_stock ? 'Menipis' : 'Aman',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}