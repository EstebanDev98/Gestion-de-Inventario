<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Estado;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Estado::create(['nombre' => 'activo']);
        Estado::create(['nombre' => 'en préstamo']);
        Estado::create(['nombre' => 'agotado']);
        Estado::create(['nombre' => 'averiado']);
    }
}
