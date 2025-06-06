<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Insumo;
use App\Models\Estado;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
            public function index(){
            // Total de insumos
                    $totalInsumos = Insumo::count();

                    // Conteo de insumos por estado
                    $insumosPorEstado = Estado::withCount('insumos')->get();

                    // Total de usuarios
                    $totalUsuarios = User::count();

                    // Usuarios por rol (asumiendo que tienes un campo 'role')
                    $usuariosPorRol = User::select('role', \DB::raw('count(*) as total'))
                                        ->groupBy('role')
                                        ->get();

                    // Insumos agotados (cantidad = 0)
                    $insumosAgotados = Insumo::where('cantidad', 0)->count();

                    // Insumos en préstamo (supongamos estado 'En préstamo')
                    $insumosEnPrestamo = Insumo::whereHas('estado', function($q) {
                        $q->where('nombre', 'en préstamo');
                    })->count();

                    // Insumos averiados
                    $insumosAveriados = Insumo::whereHas('estado', function($q) {
                        $q->where('nombre', 'averiado');
                    })->count();

                    return view('admin.reportes', compact(
                        'totalInsumos',
                        'insumosPorEstado',
                        'totalUsuarios',
                        'usuariosPorRol',
                        'insumosAgotados',
                        'insumosEnPrestamo',
                        'insumosAveriados'
                    ));
            }
}
