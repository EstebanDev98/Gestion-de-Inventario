<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Insumos Disponibles') }}
        </h2>
    </x-slot>

    <div class="py-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-4">
            <form action="{{ route('insumos.index') }}" method="GET" class="flex space-x-2">
                <x-text-input
                    name="buscar"
                    type="text"
                    placeholder="Buscar por nombre o código…"
                    value="{{ old('buscar', $busqueda) }}"
                    class="block w-full"
                />
                <x-primary-button>Buscar</x-primary-button>
            </form>
        
            @if($busqueda)
                <a href="{{ route('insumos.index') }}" class="text-sm text-gray-600 hover:underline"><x-danger-button>Limpiar Busqueda</x-danger-button>
                </a>
            @endif
            @if(auth()->user()->role === 'Administrador')
                <a href="{{ route('insumos.create') }}"
                class="ml-4 inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                    Crear Insumo
                </a>
            @endif
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            @if ($insumos->count())
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr class="text-left text-gray-700 dark:text-gray-200">
                            @if(auth()->user()->role === 'Administrador')
                                <th hidden class="px-4 py-2"></th>
                                @elseif(auth()->user()->role === 'Funcionario')
                                    <th class="px-4 py-2"></th>
                            @endif
                            <th class="px-4 py-2">Nombre</th>
                            <th class="px-4 py-2">Código</th>
                            <th class="px-4 py-2">Cantidad</th>
                            <th class="px-4 py-2">Unidad</th>
                            <th class="px-4 py-2">Estado</th>
                            <th class="px-4 py-2">Ubicación</th>
                            @if (auth()->user()->role === 'Funcionario')
                                <th hidden class="px-4 py-2">Acciones</th>
                                @elseif(auth()->user()->role === 'Administrador')
                                    <th class="px-4 py-2">Acciones</th>

                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600 text-gray-800 dark:text-gray-100">
                        @foreach ($insumos as $insumo)
                            <tr>
                                @if(auth()->user()->role === 'Administrador')
                                    <td hidden class="px-4 py-2"><input type="checkbox" class="checkbox-insumo"></td>
                                    @elseif(auth()->user()->role === 'Funcionario')
                                        <td class="px-4 py-2"><input class="checkbox-insumo" type="checkbox" value="{{ $insumo->id }}" data-nombre="{{ $insumo->nombre }}"></td>
                
                                @endif
                                
                                <td class="px-4 py-2">{{ $insumo->nombre }}</td>
                                <td class="px-4 py-2">{{ $insumo->codigo_referencia }}</td>
                                <td class="px-4 py-2">{{ $insumo->cantidad }}</td>
                                <td class="px-4 py-2">{{ $insumo->unidad_medida }}</td>
                                <td class="px-4 py-2">{{ $insumo->estado }}</td>
                                <td class="px-4 py-2">{{ $insumo->ubicacion }}</td>
                                <td class="px-4 py-2">
                                @if(auth()->user()->role === 'Administrador')
                                    <a href="{{ route('insumos.edit', $insumo->id) }}" class="btn btn-sm btn-warning"><x-primary-button>{{ __('Editar') }}</x-primary-button></a>
                                    <form action="{{ route('insumos.destroy', $insumo->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este insumo?');" style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <x-danger-button>{{ __('Eliminar') }}</x-danger-button>
                                    </form>
                                @endif                                                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if (auth()->user()->role === 'Funcionario')
                    <div class="flex justify-center">
                        <x-primary-button id="btn-prestar">Prestar</x-primary-button>
                    </div>
                @endif
                <!-- <div class="flex justify-center">
                    <x-primary-button id="btn-prestar">Prestar</x-primary-button>
                </div> -->

                <div class="mt-4">
                    {{ $insumos->withQueryString()->links() }}
                </div>
            @else
                <p class="text-center text-gray-500">No se encontraron insumos.</p>
            @endif
            
             <!-- Fondo oscuro -->
             <div id="modalPrestar" class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 hidden">
                <!-- Contenido del modal -->
                <div class="bg-white w-full max-w-xl rounded-lg shadow-lg p-6 relative">
                    <!-- Cerrar -->
                    <button id="cerrarModalPrestar" class="absolute top-2 right-2 text-gray-600 hover:text-black">
                        ✕
                    </button>

                    <form method="POST" action="{{ route('prestar.insumos') }}">
                        @csrf
                        <h2 class="text-xl font-bold mb-4">Confirmar Préstamo</h2>
                         <!-- Campo de fecha -->
                        <div class="mb-4">
                            <label for="fecha_prestamo" class="block text-sm font-medium text-gray-700">Fecha del préstamo:</label>
                            <input type="date" id="fecha_prestamo" name="fecha_prestamo"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
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
                        </div>
                    </form>
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
                    

        </div>
    </div>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

</x-app-layout>
