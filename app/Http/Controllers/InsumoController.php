<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Insumo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InsumoController extends Controller
{
    // Listado y búsqueda de insumos
    public function index(Request $request)
    {
        // Búsqueda
        $query = Insumo::query();
        if ($request->filled('search')) {
            $query->where('nombre', 'like', '%' . $request->search . '%');
        }

        // Paginación
        $insumos = $query->orderBy('fecha_prestamo', 'desc')
                         ->paginate(10)
                         ->appends(['search' => $request->search]);

        // Role
        $role = Auth::user()->role; // asume que en DB está guardado como 'funcionario'

        // Retornamos la vista genérica 'dashboard'
        return view('Funcionario.dashboard', compact('insumos', 'role'));
    }
    // Mostrar formulario de creación
    public function create()
    {
        return view('funcionario.insumosCreate');
    }

    // Guardar nuevo préstamo
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'             => 'required|string|max:255',
            'solicitante'        => 'required|string|max:255',
            'fecha_prestamo'     => 'required|date',
            'fecha_devolucion'   => 'nullable|date|after_or_equal:fecha_prestamo',
            'estado'             => 'required|in:Prestado,Devuelto',
        ]);

        Insumo::create($data);

        return redirect()->route('funcionario.insumosDashboard')
                         ->with('success', 'Préstamo creado correctamente.');
    }

    // Mostrar formulario de edición
    public function edit(Insumo $insumo)
    {
        return view('funcionario.insumosEdit', compact('insumo'));
    }

    // Actualizar préstamo existente
    public function update(Request $request, Insumo $insumo)
    {
        $data = $request->validate([
            'nombre'             => 'required|string|max:255',
            'solicitante'        => 'required|string|max:255',
            'fecha_prestamo'     => 'required|date',
            'fecha_devolucion'   => 'nullable|date|after_or_equal:fecha_prestamo',
            'estado'             => 'required|in:Prestado,Devuelto',
        ]);

        $insumo->update($data);

        return redirect()->route('funcionario.insumosDashboard')
                         ->with('success', 'Préstamo actualizado correctamente.');
    }

    // Eliminar préstamo
    public function destroy(Insumo $insumo)
    {
        $insumo->delete();

        return redirect()->route('funcionario.insumosDashboard')
                         ->with('success', 'Préstamo eliminado correctamente.');
    }
}