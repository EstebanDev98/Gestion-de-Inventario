<?php

namespace App\Http\Controllers;

use App\Models\Espacio;
use App\Models\Estado;
use App\Models\EstadoEspacio;
use App\Models\ReservaEspacio;
use Illuminate\Http\Request;

class ReservaEspacioController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'id' => ['required','exists:espacios,id'],
            'fecha' => ['required','date'],
            'inicio' => ['required'],
            'fin' => ['required']
        ]);

        $reserva = ReservaEspacio::where('espacio_id', $request->id)
            ->where('fecha_reserva', $request->fecha)
            ->where('estado', 'pendiente')
            ->where(function ($query) use ($request) {
                $query->whereBetween('hora_inicial', [$request->inicio, $request->fin])
                  ->orWhereBetween('hora_final', [$request->inicio, $request->fin])
                  ->orWhere(function ($q) use ($request) {
                      $q->where('hora_inicial', '<=', $request->inicio)
                        ->where('hora_final', '>=', $request->fin);
                    });
                })
                ->exists();
        if($reserva){
            return redirect()->route('espacios.index')->with('error','Solicitud denegada, el espacio está reservado');
        }else{
            ReservaEspacio::create([
                'espacio_id' => $request->id,
                'fecha_reserva' => $request->fecha,
                'hora_inicial' => $request->inicio,
                'hora_final' => $request->fin,
            ]);
            $estado = EstadoEspacio::where('nombre','reservado')->firstOrFail();
            if($estado){
                $espacio = Espacio::find($request->id);
                $espacio->estado_id = $estado->id;
                $espacio->save();
            }
            return redirect()->route('espacios.index')->with('success','Reserva exitosa');   
        }

    }
}
