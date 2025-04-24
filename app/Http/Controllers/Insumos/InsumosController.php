<?php

namespace App\Http\Controllers\Insumos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Insumo;
use App\Models\Prestamo;

class InsumosController extends Controller
{
    public function index(Request $request){
        $usuario = auth()->user();
        $role = strtolower($usuario->role);

        if ($role === 'funcionario') {
            $insumos = Insumo::all();
            return view('dashboard', compact('insumos', 'role'));
        }

        $consulta = Insumo::query();
        if($request->has('buscar') && $request->buscar != ''){
            $consulta->where('nombre', 'like', '%' . $request->buscar . '%');
            
        }
        $insumos = $consulta->get();
        return view('dashboard', compact('insumos','role'));
        
    }

    public function registrar_insumos(Request $request){
        $request->validate([
            'fecha_prestamo'=>['required','string','max:255'],
            'insumos'=>['required','array','min:1'],
            'insumos.*.id'=>['required', 'exists:insumos,id'],
            'insumos.*.nombre'=>['required','string','max:255'],
            'insumos.*.cantidad'=>['required','integer','min:1'],
        ]);
        
        $fecha = $request->fecha_prestamo;
        foreach ($request->insumos as $insumo) {
            Prestamo::create([
                'insumos_id' => $insumo['id'],
                'nombre' => $insumo['nombre'],
                'cantidad' => $insumo['cantidad'],
                'fecha_de_prestamo' => $fecha,
            ]);
            $insum = Insumo::find($insumo['id']);
            if($insum){
                $insum->cantidad -= $insumo['cantidad'];
                if($insum->cantidad > 0){
                    $insum->save();
                }else{
                    $insum->cantidad = 0;
                    $insum->estado = 'No disponible';
                    $insum->save();
                    return redirect()->route('dashboard')->with('error','el insumo seleccionado se agotó');

                }
            }else{
                return redirect()->route('dashboard')->with('error', 'Insumo no encotrado');
            }
            
        }
        
        return redirect()->route('dashboard')->with('success','Prestamo realizado exitosamente');
        
    }
}
