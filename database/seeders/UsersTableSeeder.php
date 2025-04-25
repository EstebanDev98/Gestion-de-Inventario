<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Borra datos antiguos (opcional)
        DB::table('users')->truncate();

        // Usuario administrador
        User::create([
            'name'     => 'Admin Principal',
            'apellido'     => 'Apellido Admin Principal',
            'email'    => 'admin@tuapp.test',
            'password' => Hash::make('password'), 
            'role'     => 'Administrador',
        ]);

        // Usuario supervisor
        User::create([
            'name'     => 'Supervisor Prueba',
            'apellido'     => 'Apellido Supervisor Prueba',
            'email'    => 'supervisor@tuapp.test',
            'password' => Hash::make('password'),
            'role'     => 'Supervisor',
        ]);

        // Usuario funcionario
        User::create([
            'name'     => 'Funcionario Prueba',
            'apellido'     => 'Apellido Funcionario Prueba',
            'email'    => 'funcionario@tuapp.test',
            'password' => Hash::make('password'),
            'role'     => 'Funcionario',
        ]);

        // (Aquí puedes agregar más registros de prueba)
    }
}
