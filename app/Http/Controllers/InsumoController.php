<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use Illuminate\Http\Request;
use App\Models\Insumo;

class InsumoController extends Controller
{
    public function index(Request $request)
    {
        $busqueda = $request->input('buscar'); 

        $insumos = Insumo::with('estado')
            ->when($busqueda, function ($query, $busqueda) {
                $query->where('nombre', 'ilike', "%busqueda%")
                      ->orWhere('codigo_referencia', 'ilike', "%busqueda%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);
        
        return view('insumos.index', compact('insumos', 'busqueda'));
        
    }   

    public function create()
    {
        $estados = Estado::all(); // Para el select
        return view('insumos.create', compact('estados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo_referencia' => 'required|string|max:100|unique:insumos',
            'descripcion' => 'nullable|string',
            'unidad_medida' => 'required|string|max:100',
            'cantidad' => 'required|numeric|min:0',
            'ubicacion' => 'required|string|max:255',
            'estado_id' => 'required|exists:estados,id',
        ]);

        Insumo::create($request->all());

        return redirect()->route('insumos.index')->with('success', 'Insumo creado correctamente');
    }

    public function show($id)
    {
        // Por ahora simplemente redireccionamos al listado
        return redirect()->route('insumos.index');
    }

    public function edit($id)
    {
        $insumo = Insumo::findOrFail($id);
        $estados = Estado::all(); // Para el select del estado
        return view('insumos.edit', compact('insumo', 'estados'));
    }

    public function update(Request $request, $id)
    {
        $insumo = Insumo::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo_referencia' => 'required|string|max:100|unique:insumos,codigo_referencia,' . $insumo->id,
            'descripcion' => 'nullable|string',
            'unidad_medida' => 'required|string|max:100',
            'cantidad' => 'required|numeric|min:0',
            'ubicacion' => 'required|string|max:255',
            'estado_id' => 'required|exists:estados,id',
        ]);

        $insumo->update($request->all());

        return redirect()->route('insumos.index')->with('success', 'Insumo actualizado correctamente');
    }

    public function destroy($id)
    {
        $insumo = Insumo::findOrFail($id);
        $insumo->delete();

        return redirect()->route('insumos.index')->with('success', 'Insumo eliminado correctamente');
    }



}
