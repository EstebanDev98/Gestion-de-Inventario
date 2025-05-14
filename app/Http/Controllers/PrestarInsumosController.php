<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Insumo;
use App\Models\Prestamo;
use App\Models\Estado;

class PrestarInsumosController extends Controller
{
    public function prestar_insumos(Request $request){
        $request->validate([
            'fecha_prestamo'=>['required','string','max:255'],
            'insumos'=>['required','array','min:1'],
            'insumos.*.id'=>['required', 'exists:insumos,id'],
            'insumos.*.cantidad'=>['required','integer','min:1'],
        ]);
        
        $fecha = $request->fecha_prestamo;
        foreach ($request->insumos as $insumo) {
            Prestamo::create([
                'insumos_id' => $insumo['id'],
                'cantidad' => $insumo['cantidad'],
                'fecha_de_prestamo' => $fecha,
            ]);
            $insum = Insumo::find($insumo['id']);
            
            $insum->cantidad -= $insumo['cantidad'];
            if($insum->cantidad >0){
                $estadoActivo = Estado::where('nombre', 'activo')->first();
                $insum->estado_id = $estadoActivo?->id;
                $insum->save();

            }else{
                $estadoAgotado = Estado::where('nombre', 'agotado')->first();
                $insum->estado_id = $estadoAgotado?->id;
                $insum->cantidad = 0;
                $insum->save();
                return redirect()->route('insumos.index')->with('error', 'El insumo seleccionado está agotado');  
            }
            
        }
        return redirect()->route('insumos.index')->with('success','Prestamo realizado con exito.');

        
    }
}
