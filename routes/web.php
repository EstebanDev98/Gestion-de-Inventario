<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Usuario\UserController;
use Illuminate\Support\Facades\Route;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $usuarios = User::orderBy('created_at', 'desc')->get();
    return view('dashboard', compact('usuarios'));
})->middleware(['auth', 'verified'])->name('dashboard');
Route::post('admin/users/store', [UserController::class, 'storeuser'])->name('admin.users.store');
Route::get('admin/users/view/{id}/update', [UserController::class, 'viewupdate'])->name('admin.user.view.update');
Route::put('admin/users/{id}/update', [UserController::class, 'updateuser'])->name('admin.user.update');
Route::delete('admin/users/{id}/delete', [UserController::class, 'deleteuser'])->name('admin.user.delete');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
