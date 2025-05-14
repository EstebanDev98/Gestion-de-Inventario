<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gestión de Espacios') }}
        </h2>
    </x-slot>

    <div class="py-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-4">
            <form action="{{ route('espacios.index') }}" method="GET" class="flex space-x-2">
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
                <a href="{{ route('espacios.index') }}" class="text-sm text-gray-600 hover:underline"><x-danger-button>Limpiar Busqueda</x-danger-button>
                </a>
            @endif
            @if(auth()->user()->role === 'Administrador')
                <a href="{{ route('espacios.create') }}"
                class="ml-4 inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                    Añadir espacio
                </a>
            @endif
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif
            @if ($espacios->count())
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr class="text-left text-gray-700 dark:text-gray-200">
                            @if(auth()->user()->role === 'Administrador')
                                <th hidden class="px-4 py-2"></th>
                                @elseif(auth()->user()->role === 'Funcionario')
                                    <th class="px-4 py-2"></th>
                            @endif
                            <th class="px-4 py-2">Nombre</th>
                            <th class="px-4 py-2">Ubicación</th>
                            <th class="px-4 py-2">Estado</th>
                            @if(auth()->user()->role === "Funcionario")
                                <th hidden class="px-4 py-2">Fecha de creación</th>
                            @endif                            
                            <th class="px-4 py-2">Acciones</th>

                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600 text-gray-800 dark:text-gray-100">
                        @foreach ($espacios as $espacio)
                            <tr>
                                @if(auth()->user()->role === 'Funcionario')
                                    <td class="px-4 py-2"><input class="checkbox-insumo" type="checkbox" value="{{ $espacio->id }}" data-nombre="{{ $espacio->nombre }}"></td>
                
                                @endif
                                
                                <td class="px-4 py-2">{{ $espacio->nombre }}</td>
                                <td class="px-4 py-2">{{ $espacio->ubicacion }}</td>
                                <td class="px-4 py-2">{{ $espacio->estado->nombre}}</td>
                                @if (auth()->user()->role === "Funcionario")
                                    <td hidden class="px-4 py-2">{{ $espacio->created_at }}</td>
                                    <td class="px-4 py-2"></td>
                                @endif
                                <td class="px-4 py-2">
                                @if(auth()->user()->role === 'Administrador')
                                    <div class="flex space-x-2">
                                        {{-- Botón Editar --}}
                                        <a href="{{ route('espacios.edit', $espacio->id) }}">
                                            <x-primary-button>{{ __('Editar') }}</x-primary-button>
                                        </a>

                                        {{-- Botón Eliminar --}}
                                        <form action="{{ route('espacios.destroy', $espacio->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este insumo?');">
                                            @csrf
                                            @method('DELETE')
                                            <x-danger-button>{{ __('Eliminar') }}</x-danger-button>
                                        </form>

                                        {{-- Botón Terminar Reserva --}}
                                        @if ($espacio->estado->nombre === 'reservado')
                                            <form action="{{ route('finalizar.reserva', $espacio->id) }}" method="POST">
                                                @csrf
                                                <x-primary-button>{{ __('Terminar reserva') }}</x-primary-button>
                                            </form>
                                        @endif
                                    </div>
                                @endif


                                @if(auth()->user()->role === 'Funcionario')
                                    <x-primary-button onclick="ShowModal(this)" class="btn btn-sm btn-green" value="{{ $espacio->id }}" data-nombre="{{ $espacio->nombre }}">{{ __('Reservar') }}</x-primary-button>
                                @endif  
                                                                                                 
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <div class="mt-4">
                    {{ $espacios->withQueryString()->links() }}
                </div>
            @else
                <p class="text-center text-gray-500">No se encontraron espacios.</p>
            @endif
            
             <!-- Fondo oscuro -->
             <div id="Mymodal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                <!-- Contenido del modal -->
                <div class="bg-white w-full max-w-xl rounded-lg shadow-lg p-6 relative">
                    <!-- Cerrar -->
                    <button id="cerrarModalPrestar" class="absolute top-2 right-2 text-gray-600 hover:text-black">
                        ✕
                    </button>

                    <form method="POST" action="{{ route('reserva-espacios.store') }}">
                        @csrf
                        <h2 class="text-xl font-bold mb-4">Confirmar reserva</h2>
                         <!-- Campo de fecha -->
                        
                            <div id="lista-insumos-reservar" class="space-y-4">
                                
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
            </div>
        </div>
    </div>
        <script>
        function ShowModal(button) {
            const nombre = button.getAttribute('data-nombre');
            const espacioId = button.value;
            const contenedor = document.getElementById('lista-insumos-reservar');

            contenedor.innerHTML = `
                <div class="mb-2">
                    <label>Fecha de reserva</label>
                    <input type="date" name="fecha" class="w-full mt-1 mb-5 p-2 border rounded">
                </div>
                <div class="mb-2">
                    <input type="hidden" name="id" value="${espacioId}">
                <div>
                <div class="mb-2">
                    <label>Inicio</label>
                    <input type="time" name="inicio" class="w-full mt-1 p-2 border rounded">
                </div>
                <div class="mb-2">
                    <label class="mb-2">Fin</label>
                    <input type="time" name="fin" class="w-full  mt-1 mb-2 border rounded">
                <div>
                <div class="mb-2">
                    <label class="mb-2">Espacio</label>
                    <input type="text" class="w-full mt-1 mb-2 border rounded" value="${nombre}" readonly>
                </div>
            `;

            // Muestra el modal
            document.getElementById("Mymodal").classList.remove("hidden");
        }

        // Ocultar el modal en cerrar y cancelar
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById("cerrarModalPrestar")?.addEventListener("click", function() {
                document.getElementById("Mymodal").classList.add("hidden");
            });

            document.getElementById("cancelarModalPrestar")?.addEventListener("click", function() {
                document.getElementById("Mymodal").classList.add("hidden");
            });
        });
    </script>


    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

</x-app-layout>
