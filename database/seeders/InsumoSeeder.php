<?php

namespace Database\Seeders;

use App\Models\Insumo;
use Illuminate\Database\Seeder;

class InsumoSeeder extends Seeder
{
    public function run()
    {
        // Crear 20 registros de prueba
        Insumo::factory()->count(20)->create();
    }
}