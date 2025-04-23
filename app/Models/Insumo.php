<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    use HasFactory;

    protected $table = 'insumos';

    // Asignación masiva
    protected $fillable = [
        'nombre',
        'solicitante',
        'fecha_prestamo',
        'fecha_devolucion',
        'estado',
    ];

    // Casts para fechas
    protected $casts = [
        'fecha_prestamo'   => 'date',
        'fecha_devolucion' => 'date',
    ];
}