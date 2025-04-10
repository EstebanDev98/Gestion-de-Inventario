<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'Administrador') {
            return $next($request);
        }
        abort(403, 'No tienes permiso para acceder a esta sección.');
    }
}
