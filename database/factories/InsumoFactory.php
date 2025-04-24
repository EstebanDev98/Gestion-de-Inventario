<?php

namespace Database\Factories;

use App\Models\Insumo;
use App\Models\Estado;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class InsumoFactory extends Factory
{
    protected $model = Insumo::class;

    public function definition()
    {
        $fechaInicio = $this->faker->dateTimeBetween('-1 month', 'now');
        $fechaDevolucion = (bool) rand(0, 1)
            ? $this->faker->dateTimeBetween($fechaInicio, '+1 month')
            : null;

        return [
            'nombre'           => Str::title($this->faker->words(3, true)),
            'solicitante'      => $this->faker->name(),
            'cantidad'         => $this->faker->numberBetween(1,50),
            'fecha_prestamo'   => $fechaInicio->format('Y-m-d'),
            'fecha_devolucion' => $fechaDevolucion?->format('Y-m-d'),
            // 'estado'           => $fechaDevolucion ? 'Activo':'Agotado',
        ];
    }
}