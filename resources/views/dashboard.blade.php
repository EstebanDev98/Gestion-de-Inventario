<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Overview') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @switch($role)
                @case('administrador')
                    <div class="bg-white dark:bg-gray-800 overflow-x-auto shadow-sm sm:rounded-lg p-6" x-data="{ open: false }">
                        <div class="p-6 text-gray-900 dark:text-gray-100 dashboard">
                            <p class="text-lg font-semibold mb-4">Gestiona tus usuarios</p>
                            <button @click="open = true"
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                                Nuevo usuario
                            </button>
                        </div>


                        @if(session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if ($usuarios->count() > 0)
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 mt-6 text-sm text-gray-900 dark:text-gray-100">
                                <thead class="bg-gray-100 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-4 py-2 text-left">Nombre</th>
                                        <th class="px-4 py-2 text-left">Apellido</th>
                                        <th class="px-4 py-2 text-left">Email</th>
                                        <th class="px-4 py-2 text-left">Rol</th>
                                        <th class="px-4 py-2 text-left">Fecha de creación</th>
                                        <th class="px-4 py-2 text-left">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-300 dark:divide-gray-700">
                                    @foreach ($usuarios as $usuario)
                                        <tr class="border-t dark:border-gray-700">
                                            <td class="px-4 py-2">{{ $usuario->name }}</td>
                                            <td class="px-4 py-2">{{ $usuario->apellido }}</td>
                                            <td class="px-4 py-2">{{ $usuario->email }}</td>
                                            <td class="px-4 py-2">{{ ucfirst($usuario->role) }}</td>
                                            <td class="px-4 py-2">{{ $usuario->created_at->format('d/m/Y H:i') }}</td>
                                            <td class="px-4 py-2 flex gap-2">
                                                <a href="{{ route('admin.users.edit', $usuario->id) }}"
                                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">
                                                    Editar
                                                </a>
                                                <form action="{{ route('admin.users.destroy', $usuario->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                                        Borrar
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-center text-gray-500 dark:text-gray-400 mt-6">No hay usuarios creados</p>
                        @endif

                        <!-- Modal Crear Usuario -->
                        <div x-show="open"
                             x-transition.opacity
                             class="fixed inset-0 bg-black bg-opacity-50 z-40 flex items-center justify-center">
                            <div @click.outside="open = false"
                                 x-transition
                                 class="bg-white dark:bg-gray-800 w-full max-w-lg mx-auto rounded-lg shadow-lg p-6 relative z-50">
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Crear Usuario</h2>

                                <form action="{{ route('admin.users.store') }}" method="POST">
                                    @csrf
                                    <!-- Name -->
                                    <div class="mb-4">
                                        <x-input-label for="name" :value="__('Name')" />
                                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                    </div>
                                    <!-- Apellido -->
                                    <div class="mb-4">
                                        <x-input-label for="name" :value="__('Apellido')" />
                                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="apellido" :value="old('apellido')" required autofocus />
                                        <x-input-error :messages="$errors->get('apellido')" class="mt-2" />
                                    </div>

                                    <!-- Email -->
                                    <div class="mb-4">
                                        <x-input-label for="email" :value="__('Email')" />
                                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>

                                    <!-- Password -->
                                    <div class="mb-4">
                                        <x-input-label for="password" :value="__('Password')" />
                                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                    </div>

                                    <!-- Confirm Password -->
                                    <div class="mb-4">
                                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                    </div>

                                    <!-- Rol -->
                                    <div class="mb-4">
                                        <label for="role" class="block text-sm font-medium text-white">Rol</label>
                                        <select name="role" id="role"
                                            class="mt-1 block w-full rounded-md bg-gray-900 border-gray-700 text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            <option value="Funcionario" selected>Funcionario</option>
                                            <option value="Supervisor">Supervisor</option>
                                            <option value="Administrador">Administrador</option>
                                        </select>
                                    </div>

                                    <div class="flex justify-end gap-4 mt-6">
                                        <button type="button" @click="open = false"
                                                class="bg-gray-300 dark:bg-gray-600 text-gray-900 dark:text-white px-4 py-2 rounded">
                                            Cancelar
                                        </button>
                                        <button type="submit"
                                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                                            Crear
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @break
                @case('supervisor')
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                        <h1 class="text-2xl font-bold mb-4">Bienvenido, Supervisor</h1>
                        <p class="text-lg">Has iniciado sesión con el rol <strong>Supervisor</strong>.</p>
                        <p>En breve tendrás aquí tus reportes y métricas.</p>
                    </div>
                @break
                @case('funcionario')
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                        <h1 class="text-2xl font-bold mb-4">Bienvenido, Funcionario</h1>
                        <p class="text-lg">Has iniciado sesión con el rol <strong>Funcionario</strong>.</p>
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
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</x-app-layout>
