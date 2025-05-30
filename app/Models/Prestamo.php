<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    use HasFactory;
    protected $fillable = [
        'insumos_id',
        'nombre',
        'cantidad',
        'fecha_de_prestamo'
    ];
    public $timestamps = false;

    public function insumo()
    {
        return $this->belongsTo(Insumo::class);
    }

}
