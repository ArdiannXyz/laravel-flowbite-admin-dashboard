<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ActivityExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $aktivitas;

    public function __construct($aktivitas)
    {
        $this->aktivitas = $aktivitas;
    }

    public function collection()
    {
        return $this->aktivitas;
    }

    public function headings(): array
    {
        return [
            'Waktu',
            'Pengguna',
            'Role',
            'Aktivitas',
            'Keterangan',
        ];
    }

    public function map($log): array
    {
        return [
            \Carbon\Carbon::parse($log->created_at)->format('d/m/Y H:i'),
            $log->user->name ?? 'System',
            ucfirst($log->user->role ?? '-'),
            $log->type === 'in' ? 'Barang Masuk' : 'Barang Keluar',
            'Pencatatan ' . ($log->type === 'in' ? 'penerimaan' : 'pengeluaran') . ' ' . ($log->product->name ?? 'barang') . ' (' . $log->quantity . ' unit)',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}