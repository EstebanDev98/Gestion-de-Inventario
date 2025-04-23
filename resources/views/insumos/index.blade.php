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
                            <th class="px-4 py-2">Nombre</th>
                            <th class="px-4 py-2">Código</th>
                            <th class="px-4 py-2">Cantidad</th>
                            <th class="px-4 py-2">Unidad</th>
                            <th class="px-4 py-2">Estado</th>
                            <th class="px-4 py-2">Ubicación</th>
                            <th class="px-4 py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600 text-gray-800 dark:text-gray-100">
                        @foreach ($insumos as $insumo)
                            <tr>
                                <td class="px-4 py-2">{{ $insumo->nombre }}</td>
                                <td class="px-4 py-2">{{ $insumo->codigo_referencia }}</td>
                                <td class="px-4 py-2">{{ $insumo->cantidad }}</td>
                                <td class="px-4 py-2">{{ $insumo->unidad_medida }}</td>
                                <td class="px-4 py-2">{{ $insumo->estado->nombre }}</td>
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

                <div class="mt-4">
                    {{ $insumos->withQueryString()->links() }}
                </div>
            @else
                <p class="text-center text-gray-500">No se encontraron insumos.</p>
            @endif
        </div>
    </div>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

</x-app-layout>
