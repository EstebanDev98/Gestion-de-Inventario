<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Usuario\UserController;
use Illuminate\Support\Facades\Route;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        // Normalizamos a minúsculas
        $role = strtolower($user->role);

        if ($role === 'administrador') {
            $usuarios = User::orderBy('created_at', 'desc')->get();
            return view('dashboard', compact('usuarios', 'role'));
        }

        return view('dashboard', compact('role'));
    })->name('dashboard');

    // CRUD de usuarios: sigue protegiéndolo con el middleware
     Route::middleware(['auth','is_admin'])->group(function(){

          // 1. Mostrar el listado (o usar tu dashboard)
          Route::get('admin/users', [UserController::class, 'index'])
               ->name('admin.users.index');
     
          // 2. Guardar nuevo usuario
          Route::post('admin/users/store', [UserController::class, 'storeUser'])
               ->name('admin.users.store');
     
          // 3. Mostrar formulario de edición
          Route::get('admin/users/{id}/edit', [UserController::class, 'editUser'])
               ->name('admin.users.edit');
     
          // 4. Procesar la actualización
          Route::put('admin/users/{id}', [UserController::class, 'updateUser'])
               ->name('admin.users.update');
     
          // 5. Borrar usuario
          Route::delete('admin/users/{id}', [UserController::class, 'destroyUser'])
               ->name('admin.users.destroy');
     
     });

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])
         ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
         ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
         ->name('profile.destroy');
});

require __DIR__.'/auth.php';
