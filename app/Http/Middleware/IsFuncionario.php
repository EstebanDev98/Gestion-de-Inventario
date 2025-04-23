<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsFuncionario
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'Funcionario') {
            return $next($request);
        }

        abort(403, 'No tienes permiso para acceder a esta ruta.');
    }
}
