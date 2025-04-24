<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Usuarios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @switch($role)
                @case('administrador')
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <div class="flex justify-between items-center mb-4">
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">Gestiona tus usuarios</p>
                            <button 
                                id="btn-crear"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
                                Nuevo usuario
                            </button>
                        </div>

                        @if(session('success'))
                            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($usuarios->count() > 0)
                            <table class="min-w-full text-sm text-left text-gray-800 dark:text-gray-200">
                                <thead class="bg-gray-100 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-4 py-2">Nombre</th>
                                        <th class="px-4 py-2">Email</th>
                                        <th class="px-4 py-2">Rol</th>
                                        <th class="px-4 py-2">Fecha de creación</th>
                                        <th class="px-4 py-2">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-300 dark:divide-gray-700">
                                    @foreach ($usuarios as $usuario)
                                        <tr>
                                            <td class="px-4 py-2">{{ $usuario->name }}</td>
                                            <td class="px-4 py-2">{{ $usuario->email }}</td>
                                            <td class="px-4 py-2">{{ ucfirst($usuario->role) }}</td>
                                            <td class="px-4 py-2">{{ $usuario->created_at->format('d/m/Y H:i') }}</td>
                                            <td class="px-4 py-2 flex space-x-2">
                                                <a href="{{ route('admin.users.edit', $usuario->id) }}"
                                                class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded">
                                                    Editar
                                                </a>
                                                <form action="{{ route('admin.users.destroy', $usuario->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">
                                                        Borrar
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-center text-gray-500 mt-6">No hay usuarios creados</p>
                        @endif
                    </div>

                    <!-- Modal Tailwind -->
                    <div id="modalCrearUsuario" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                        <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6 relative">
                            <button id="cerrarModalUsuario" class="absolute top-2 right-2 text-gray-600 hover:text-black">✕</button>

                            <form action="{{ route('admin.users.store') }}" method="POST">
                                @csrf
                                <h2 class="text-xl font-bold mb-4 text-gray-800">Crear Usuario</h2>

                                <!-- Nombre -->
                                <div class="mb-4">
                                    <x-input-label for="name" :value="__('Name')" />
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
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
                                    <label for="role" class="block text-sm font-medium text-gray-700">Rol</label>
                                    <select name="role" id="role"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="funcionario" selected>Funcionario</option>
                                        <option value="supervisor">Supervisor</option>
                                        <option value="administrador">Administrador</option>
                                    </select>
                                </div>

                                <div class="flex justify-end space-x-2">
                                    <button type="button" id="cancelarModalUsuario" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">
                                        Cancelar
                                    </button>
                                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                        Crear
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Script Modal -->
                    <script>
                        const modal1 = document.getElementById('modalCrearUsuario');
                        const abrir = document.getElementById('btn-crear');
                        const cerrar = document.getElementById('cerrarModalUsuario');
                        const cancelar = document.getElementById('cancelarModalUsuario');

                        abrir.addEventListener('click', () => modal1.classList.remove('hidden'));
                        cerrar.addEventListener('click', () => modal1.classList.add('hidden'));
                        cancelar.addEventListener('click', () => modal1.classList.add('hidden'));
                    </script>
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
                        <h1 class="text-4xl font-bold mb-4">Bienvenido, Funcionario</h1>
                       
                        <p class="text-3xl font-bold text-black-900 mb-4">Prestamo de Insumos</p>
                        <form action="#" method="GET">
                            <div class="mb-4 flex items-center space-x-2">
                                <input class="rounded  w-1/2" placeholder="Buscar">
                                <button class="rounded bg-blue-500 h-10 w-1/6" name="buscar">Buscar</button>
                            </div>
                        </form>
                        @if(session('success'))
                            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
                                {{ session('success') }}
                            </div>
                            @elseif(session('error'))
                                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endelseif    
                        @endif
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                    
                                <tr>
                                    <th class="px-2 py-2 text-center"></th>
                                    <th class="px-2 py-2 text-center">Nombre</th>
                                    <th class="px-2 py-2 text-center">Código</th>
                                    <th class="px-2 py-2 text-center">Descripción</th>
                                    <th class="px-2 py-2 text-center">Categoría</th>
                                    <th class="px-2 py-2 text-center">Unidad de medida</th>
                                    <th class="px-2 py-2 text-center">Cantidad</th>
                                    <th class="px-2 py-2 text-center">Ubicación</th>
                                    <th class="px-2 py-2 text-center">Fecha de registro</th>
                                    <th class="px-2 py-2 text-center">Precio</th>
                                    <th class="px-2 py-2 text-center">Estado</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($insumos as $insumo)
                                    <tr>
                                        <td><input class="checkbox-insumo" type="checkbox" value="{{ $insumo->id }}" data-nombre="{{ $insumo->nombre }}"></td>
                                        <td>{{ $insumo->nombre }}</td>
                                        <td>{{ $insumo->codigo }}</td>
                                        <td>{{ $insumo->descripcion }}</td>
                                        <td>{{ $insumo->categoria }}</td>
                                        <td>{{ $insumo->unidad_de_medida }}</td>
                                        <td>{{ $insumo->cantidad }}</td>
                                        <td>{{ $insumo->ubicacion }}</td>
                                        <td>{{ $insumo->fecha_de_registro }}</td>
                                        <td>{{ $insumo->precio }}</td>
                                        <td>{{ $insumo->estado }}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <button class="rounded w-25 h-10 bg-blue-500 text-2xl" id="btn-prestar">Prestar</button>

                        <!-- Fondo oscuro -->
                        <div id="modalPrestar" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                            <!-- Contenido del modal -->
                            <div class="bg-white w-full max-w-xl rounded-lg shadow-lg p-6 relative">
                                <!-- Cerrar -->
                                <button id="cerrarModalPrestar" class="absolute top-2 right-2 text-gray-600 hover:text-black">
                                    ✕
                                </button>

                                <form method="POST" action="{{ route('registrar.insumos') }}">
                                    @csrf
                                    <h2 class="text-xl font-bold mb-4">Confirmar Préstamo</h2>
                                     <!-- Campo de fecha -->
                                    <div class="mb-4">
                                        <label for="fecha_prestamo" class="block text-sm font-medium text-gray-700">Fecha del préstamo:</label>
                                        <input type="date" id="fecha_prestamo" name="fecha_prestamo"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                            required>
                                    </div>

                                    <div id="lista-insumos-prestar" class="space-y-4">
                                        <!-- Aquí se insertarán dinámicamente los insumos -->
                                    </div>

                                    <div class="mt-6 flex justify-end">
                                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 mr-2">
                                            Confirmar
                                        </button>
                                        <button type="button" id="cancelarModalPrestar" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">
                                            Cancelar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <script>
                            const modal = document.getElementById('modalPrestar');
                            const abrirBtn = document.getElementById('btn-prestar');
                            const cerrarBtn = document.getElementById('cerrarModalPrestar');
                            const cancelarBtn = document.getElementById('cancelarModalPrestar');
                            const listaInsumos = document.getElementById('lista-insumos-prestar');

                            abrirBtn.addEventListener('click', () => {
                                listaInsumos.innerHTML = '';

                                const seleccionados = document.querySelectorAll('.checkbox-insumo:checked');
                                if (seleccionados.length === 0) {
                                    listaInsumos.innerHTML = '<p class="text-red-500">Selecciona al menos un insumo.</p>';
                                } else {
                                    seleccionados.forEach(cb => {
                                        const id = cb.value;
                                        const nombre = cb.dataset.nombre;

                                        listaInsumos.innerHTML += `
                                            <div>
                                                <input type="hidden" name="insumos[${id}][id]" value="${id}">
                                                <input type="text" name="insumos[${id}][nombre]" value="${nombre}"
                                                    class="w-full mb-3 p-2 border  rounded" readonly>
                                                <input type="number" name="insumos[${id}][cantidad]" 
                                                    class="w-full mt-1 p-2 border rounded" 
                                                    placeholder="Cantidad a prestar" min="1" required>
                                                
                                            </div>
                                        `;
                                    });
                                }

                                modal.classList.remove('hidden');
                            });

                            cerrarBtn.addEventListener('click', () => modal.classList.add('hidden'));
                            cancelarBtn.addEventListener('click', () => modal.classList.add('hidden'));
                        </script>



                        
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
