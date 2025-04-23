<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use App\Models\Insumo;

class Estado extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];

    public function insumos()
    {
        return $this->hasMany(Insumo::class);
    }
}


