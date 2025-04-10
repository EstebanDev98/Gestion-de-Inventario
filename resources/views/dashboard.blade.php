<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @switch($role)
                @case('administrador')
                    <div class="bg-white dark:bg-gray-800 overflow-x-auto shadow-sm sm:rounded-lg p-6">
                        <div class="p-6 text-gray-900 dark:text-gray-100 dashboard">
                            <p class="titulo-dashboard">Gestiona tus usuarios</p>
                            <button class="btn btn-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#ModalCrearUsuario">
                                Nuevo usuario
                            </button>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success mt-4">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($usuarios->count() > 0)
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 mt-6 text-sm text-gray-900 dark:text-gray-100">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Rol</th>
                                        <th>Fecha de creación</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($usuarios as $usuario)
                                        <tr>
                                            <td>{{ $usuario->name }}</td>
                                            <td>{{ $usuario->email }}</td>
                                            <td>{{ ucfirst($usuario->role) }}</td>
                                            <td>{{ $usuario->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.user.view.update', $usuario->id) }}"
                                                       class="btn btn-warning">
                                                        Editar
                                                    </a>
                                                    <form action="{{ route('admin.user.delete', $usuario->id) }}"
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="btn btn-danger">
                                                            Borrar
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-center text-secondary mt-6">
                                No hay usuarios creados
                            </p>
                        @endif
                    </div>

                    <!-- Modal Crear Usuario -->
                    <div class="modal fade" id="ModalCrearUsuario" tabindex="-1"
                         aria-labelledby="miModalCrearUsuario" aria-hidden="true"
                         data-bs-backdrop="static" data-bs-keyboard="false">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="miModalCrearUsuario">
                                        Creación de usuario
                                    </h5>
                                    <button type="button" class="btn-close"
                                            data-bs-dismiss="modal"
                                            aria-label="Cerrar"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('admin.users.store') }}"
                                          method="POST">
                                        @csrf

                                        <!-- Name -->
                                        <div class="mb-4">
                                            <x-input-label for="name" :value="__('Name')" />
                                            <x-text-input id="name"
                                                          class="block mt-1 w-full"
                                                          type="text"
                                                          name="name"
                                                          :value="old('name')"
                                                          required autofocus
                                                          autocomplete="name" />
                                            <x-input-error :messages="$errors->get('name')"
                                                           class="mt-2" />
                                        </div>

                                        <!-- Email -->
                                        <div class="mb-4">
                                            <x-input-label for="email" :value="__('Email')" />
                                            <x-text-input id="email"
                                                          class="block mt-1 w-full"
                                                          type="email"
                                                          name="email"
                                                          :value="old('email')"
                                                          required
                                                          autocomplete="username" />
                                            <x-input-error :messages="$errors->get('email')"
                                                           class="mt-2" />
                                        </div>

                                        <!-- Password -->
                                        <div class="mb-4">
                                            <x-input-label for="password" :value="__('Password')" />
                                            <x-text-input id="password"
                                                          class="block mt-1 w-full"
                                                          type="password"
                                                          name="password"
                                                          required
                                                          autocomplete="new-password" />
                                            <x-input-error :messages="$errors->get('password')"
                                                           class="mt-2" />
                                        </div>

                                        <!-- Confirm Password -->
                                        <div class="mb-4">
                                            <x-input-label for="password_confirmation"
                                                           :value="__('Confirm Password')" />
                                            <x-text-input id="password_confirmation"
                                                          class="block mt-1 w-full"
                                                          type="password"
                                                          name="password_confirmation"
                                                          required
                                                          autocomplete="new-password" />
                                            <x-input-error :messages="$errors->get('password_confirmation')"
                                                           class="mt-2" />
                                        </div>

                                        <!-- Rol -->
                                        <div class="mb-4">
                                            <label for="role"
                                                   class="block text-sm font-medium text-white">
                                                Rol
                                            </label>
                                            <select name="role" id="role"
                                                class="mt-1 block w-full rounded-md
                                                       bg-gray-900 border-gray-700
                                                       text-white shadow-sm
                                                       focus:border-indigo-500
                                                       focus:ring-indigo-500 sm:text-sm">
                                                <option value="funcionario" selected>
                                                    Funcionario
                                                </option>
                                                <option value="supervisor">
                                                    Supervisor
                                                </option>
                                                <option value="administrador">
                                                    Administrador
                                                </option>
                                            </select>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button"
                                                    class="btn btn-secondary"
                                                    data-bs-dismiss="modal">
                                                Cancelar
                                            </button>
                                            <button type="submit"
                                                    class="btn btn-primary">
                                                Crear
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @break

                @case('supervisor')
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                        <h1 class="text-2xl font-bold mb-4">Bienvenido, Supervisor</h1>
                        <p class="text-lg">
                            Has iniciado sesión con el rol <strong>Supervisor</strong>.
                        </p>
                        <p>En breve tendrás aquí tus reportes y métricas.</p>
                    </div>
                @break

                @case('funcionario')
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                        <h1 class="text-2xl font-bold mb-4">Bienvenido, Funcionario</h1>
                        <p class="text-lg">
                            Has iniciado sesión con el rol <strong>Funcionario</strong>.
                        </p>
                        <p>Este espacio se usará para tus tareas y solicitudes.</p>
                    </div>
                @break

                @default
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                        <p>Rol no reconocido.</p>
                    </div>
            @endswitch

        </div>
    </div>
</x-app-layout>
