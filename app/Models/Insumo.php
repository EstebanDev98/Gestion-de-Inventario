<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Estado;

class Insumo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'codigo_referencia',
        'descripcion',
        'unidad_medida',
        'cantidad',
        'ubicacion',
        'estado_id',
    ];

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }
}


