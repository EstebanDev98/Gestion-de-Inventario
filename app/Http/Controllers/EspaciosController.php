<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Espacio;
use App\Models\EstadoEspacio;
use App\Models\ReservaEspacio;

class EspaciosController extends Controller
{
     public function index(Request $request)
    {
        $busqueda = $request->input('buscar');
    
        $espacios = Espacio::with('estado')
            ->when($busqueda, function ($query, $busqueda) {
                $query->where('nombre', 'like', "%{$busqueda}%")
                       ->orWhere('ubicacion', 'like', "%{$busqueda}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5)
            ->appends(['buscar' => $busqueda]);
    
        return view('espacios.index', compact('espacios', 'busqueda'));
    }
   

    public function create()
    {
        $estadosespacios = EstadoEspacio::all(); // Para el select
        return view('espacios.create', compact('estadosespacios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/|unique:espacios',
            'ubicacion' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'estado_id' => 'required|exists:estados,id',
            
        ]);

        Espacio::create($request->all());

        return redirect()->route('espacios.index')->with('success', 'Espacio añadido correctamente');
    }

    public function show($id)
    {
        // Por ahora simplemente redireccionamos al listado
        return redirect()->route('espacios.index');
    }

    public function edit($id)
    {
        $espacios = Espacio::findOrFail($id);
        $estados = EstadoEspacio::all(); // Para el select del estado
        
        return view('espacios.edit', compact('espacios', 'estados'));
    }

    public function update(Request $request, $id)
    {
        $espacios = Espacio::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'ubicacion' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'estado_id' => 'required|exists:estados,id',
        ]);

        $espacios->update($request->all());

        return redirect()->route('espacios.index')->with('success', 'Espacio actualizado con exito.');
    }

    public function destroy($id)
    {
        $espacios = Espacio::findOrFail($id);
        $espacios->delete();

        return redirect()->route('espacios.index')->with('error', 'Espacio eliminado con exito.');
    }

    public function finalizarReserva($espacio_id){
        $espacio= Espacio::findOrFail($espacio_id);
        
        $reserva = ReservaEspacio::where('espacio_id',$espacio->id)
            ->where('estado','pendiente')
            ->latest('fecha_reserva')
            ->first();
        if($reserva){
            $reserva->estado = 'finalizada';
            $reserva->save();
        }

        $estadosespacios = EstadoEspacio::where('nombre','disponible')->first();
        if($estadosespacios){
            $espacio->estado_id = $estadosespacios->id;
            $espacio->save();
        }
        return redirect()->route('espacios.index')->with('success','Reserva finalaza.');
    }



}
