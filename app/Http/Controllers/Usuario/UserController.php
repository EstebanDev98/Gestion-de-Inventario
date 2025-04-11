<?php

namespace App\Http\Controllers\Usuario;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // 1. Listado de usuarios
    public function index()
    {
        $user     = auth()->user();
        $usuarios = User::orderBy('created_at','desc')->get();
        $role     = Auth::user()->role;      // obtengo el rol del usuario autenticado
        // Puedes reutilizar tu vista de dashboard o crear una nueva:
        return view('dashboard', compact('usuarios','role'));
    }

    // 2. Guardar nuevo usuario
    public function storeUser(Request $request)
    {
        $data = $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|string|min:6|confirmed',
            'role'                  => ['required', Rule::in(['funcionario','supervisor','administrador'])],
        ]);

        User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
            'role'     => $data['role'],
        ]);

        return back()->with('success', 'Usuario creado correctamente.');
    }

    // 3. Mostrar formulario de edición
    public function editUser($id)
    {
        $usuario = User::findOrFail($id);
        return view('vista_edit', compact('usuario'));
    }

    // 4. Procesar la actualización
    public function updateUser(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => ['required','email', Rule::unique('users','email')->ignore($usuario->id)],
            'role'  => ['required', Rule::in(['funcionario','supervisor','administrador'])],
            // Si quieres permitir cambiar contraseña:
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $usuario->name  = $data['name'];
        $usuario->email = $data['email'];
        $usuario->role  = $data['role'];

        if (!empty($data['password'])) {
            $usuario->password = bcrypt($data['password']);
        }

        $usuario->save();

        return redirect()
               ->route('admin.users.index')
               ->with('success', 'Usuario actualizado correctamente.');
    }

    // 5. Borrar usuario
    public function destroyUser($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();

        return redirect()
               ->route('dashboard')
               ->with('success', 'Usuario eliminado correctamente.');
    }
}
