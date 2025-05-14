<?php

namespace Database\Seeders;
use App\Models\EstadoEspacio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadoEspacioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EstadoEspacio::create(['nombre' => 'disponible']);
        EstadoEspacio::create(['nombre' => 'reservado']);
    }
}
