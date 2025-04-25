<?php

namespace App\Http\Controllers\Usuario;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



class UserController extends Controller
{

    public function storeuser(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role'=> ['required', 'string', 'in:Funcionario,Supervisor,Administrador'],

        ]);
        $usuario = User::create([
            'name' => $request->name,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('dashboard')->with('success', 'Usuario creado exitosamente');
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
            'role'  => ['required', Rule::in(['Funcionario','Supervisor','Administrador'])],
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
               ->route('dashboard')
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
