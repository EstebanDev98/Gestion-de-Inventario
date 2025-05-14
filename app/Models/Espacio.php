<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EstadoEspacio;

class Espacio extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'ubicacion',
        'estado_id',
        'inicio'
    ];
    // public $timestamps = false;
    public function estado()
    {
        return $this->belongsTo(EstadoEspacio::class);
    }
    public function reservas(){
        return $this->hasMany(ReservaEspacio::class);
    }

}
