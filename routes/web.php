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
        $usuario = auth()->user();
        // Normalizamos a minúsculas
        $role = strtolower($usuario->role);

        if ($role === 'administrador') {
            $usuarios = User::orderBy('created_at', 'desc')->get();
            return view('dashboard', compact('usuarios', 'role'));
        }

        return view('dashboard', compact('role'));
    })->name('dashboard');

    // CRUD de usuarios: sigue protegiéndolo con el middleware
    Route::middleware('is_admin')->group(function () {
        Route::post('admin/users/store', [UserController::class, 'storeuser'])
             ->name('admin.users.store');
        Route::get('admin/users/view/{id}/update', [UserController::class, 'viewupdate'])
             ->name('admin.user.view.update');
        Route::put('admin/users/{id}/update', [UserController::class, 'updateuser'])
             ->name('admin.user.update');
        Route::delete('admin/users/{id}/delete', [UserController::class, 'deleteuser'])
             ->name('admin.user.delete');
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
