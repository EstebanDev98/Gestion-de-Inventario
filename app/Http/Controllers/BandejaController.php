<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Insumo; // o el nombre correcto del modelo
use App\Models\Estado; // si necesitas usarlo para mapear nombres

class BandejaController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Solo roles autorizados
        if (!in_array($user->role, ['Administrador', 'Supervisor'])) {
            abort(403, 'Acceso denegado.');
        }

        // Asumiendo que cada insumo tiene un estado_id y hay relación con Estado
        $insumos = Insumo::with('estado')->get();

        // Clasificamos
        $prestados = Insumo::where('estado_id', 2)->get(); // Prestado
        $enBodega  = Insumo::where('estado_id', 1)->get(); // Activo (en bodega)
        $agotados  = Insumo::where('estado_id', 3)->get(); // Agotado

        return view('bandeja.index', compact('prestados', 'enBodega', 'agotados'));
    }
}
