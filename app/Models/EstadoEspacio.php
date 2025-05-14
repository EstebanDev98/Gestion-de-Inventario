<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoEspacio extends Model
{
    use HasFactory;
    protected $fillable = ['nombre'];
    protected $table = 'estadoespacios';


    public function espacios(){
        return $this->hasMany(Espacio::class);
    }
}
