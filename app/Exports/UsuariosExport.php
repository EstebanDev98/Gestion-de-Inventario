<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class UsuariosExport implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        return User::select('name', 'email', 'created_at')->get();
    }

    public function headings(): array
    {
        return [
            'Nombre',
            'Correo Electrónico',
            'Fecha de Registro'
        ];
    }

    public function title(): string
    {
        return 'Reporte de Usuarios';
    }
}
