<?php

namespace App\Exports;

use App\Models\Prestamo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class PrestamosExport implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        return Prestamo::with('insumo')->get()->map(function ($prestamo) {
            return [
                'insumo' => $prestamo->insumo->nombre ?? 'N/A',
                'fecha_prestamo' => $prestamo->fecha_prestamo,
                'fecha_devolucion' => $prestamo->fecha_devolucion,
                'estado' => $prestamo->estado,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Insumo',
            'Fecha de Préstamo',
            'Fecha de Devolución',
            'Estado'
        ];
    }

    public function title(): string
    {
        return 'Reporte de Préstamos';
    }
}
