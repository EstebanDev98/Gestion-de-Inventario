<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservaEspacio extends Model
{
    use HasFactory;
    protected $fillable = [
        'espacio_id',
        'fecha_reserva',
        'hora_inicial',
        'hora_final',
        'estado',
    ];
    public $timestamps = false;
    public $table = 'reserva_espacios';
    public function espacio(){
        return $this->belongsTo(Espacio::class);
    }
}
