<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function storeuser(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role'=> ['required', 'string', 'in:funcionario,supervisor,administrador'],

        ]);
        $usuario = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('dashboard')->with('success', 'Usuario creado exitosamente');
    }
    public function viewupdate($id){
        $usuario = User::findOrFail($id);
        return view('vista_edit', compact('usuario'));
    }
    public function updateuser(Request $request, $id){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($id)],
            'password' => 'nullable|confirmed|min:8', // La contraseña es opcional, solo se actualizará si se proporciona
            'role' => 'required|string|in:Funcionario,Supervisor,Administrador',
        ]);
        $usuario = User::findOrFail($id);
        $usuario->name = $validated['name'];
        $usuario->email = $validated['email'];

        if ($request->filled('password')) {
            $usuario->password = Hash::make($validated['password']);
        }
    
        $usuario->role = $validated['role'];
        $usuario->save();
        return redirect()->route('dashboard')->with('success', 'Usuario actualizado exitosamente.');

    }

    public function deleteuser($id){
        $usuario = User::findOrFail($id);
        $usuario->delete();
        return redirect()->route('dashboard')->with('success', 'Usuario eliminado exitosamente.');
    }
}
