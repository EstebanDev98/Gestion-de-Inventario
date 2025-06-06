<?php

namespace App\Exports;

use App\Models\Insumo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class InsumosExport implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        return Insumo::select('nombre', 'codigo_referencia', 'descripcion')->get();
    }

    public function headings(): array
    {
        return [
            'Nombre',
            'Código de Referencia',
            'Descripción'
        ];
    }

    public function title(): string
    {
        return 'Reporte de Insumos';
    }
}
