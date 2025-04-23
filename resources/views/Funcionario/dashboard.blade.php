<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @switch($role)
                {{-- Caso Funcionario --}}
                @case('Funcionario')
                    <div class="bg-white dark:bg-gray-800 overflow-x-auto shadow-sm sm:rounded-lg p-6">
                        <h1 class="text-2xl font-bold mb-4 text-center text-gray-900 dark:text-gray-100">
                            Dashboard de Préstamo de Insumos
                        </h1>

                        {{-- Alertas --}}
                        @if(session('success'))
                            <div class="alert alert-success mb-4">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger mb-4">
                                {{ session('error') }}
                            </div>
                        @endif

                        {{-- Botón Nuevo Préstamo --}}
                        <div class="mb-4 text-right">
                            <a href="{{ route('funcionario.insumos.create') }}" class="btn btn-primary">
                                Nuevo Préstamo
                            </a>
                        </div>

                        {{-- Buscador --}}
                        <form action="{{ route('dashboard') }}" method="GET" class="form-inline mb-4">
                            <input
                                type="text"
                                name="search"
                                class="form-control mr-2"
                                placeholder="Buscar insumos..."
                                value="{{ request('search') }}"
                            >
                            <button type="submit" class="btn btn-secondary">Buscar</button>
                        </form>

                        {{-- Tabla de Insumos --}}
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm text-gray-900 dark:text-gray-100">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">#</th>
                                    <th class="px-4 py-2">Nombre</th>
                                    <th class="px-4 py-2">Solicitante</th>
                                    <th class="px-4 py-2">Fecha Préstamo</th>
                                    <th class="px-4 py-2">Fecha Devolución</th>
                                    <th class="px-4 py-2">Estado</th>
                                    <th class="px-4 py-2">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($insumos as $insumo)
                                    <tr>
                                        <td class="px-4 py-2">
                                            {{ $loop->iteration + ($insumos->currentPage()-1)*$insumos->perPage() }}
                                        </td>
                                        <td class="px-4 py-2">{{ $insumo->nombre }}</td>
                                        <td class="px-4 py-2">{{ $insumo->solicitante }}</td>
                                        <td class="px-4 py-2">{{ $insumo->fecha_prestamo->format('d/m/Y') }}</td>
                                        <td class="px-4 py-2">
                                            {{ $insumo->fecha_devolucion?->format('d/m/Y') ?? '-' }}
                                        </td>
                                        <td class="px-4 py-2">
                                            <span class="badge {{ $insumo->estado == 'Devuelto' ? 'badge-success' : 'badge-warning' }}">
                                                {{ $insumo->estado }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2">
                                            <a href="{{ route('funcionario.insumos.edit', $insumo) }}"
                                               class="btn btn-sm btn-warning">
                                                Editar
                                            </a>
                                            <form
                                                action="{{ route('funcionario.insumos.destroy', $insumo) }}"
                                                method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('¿Eliminar préstamo?')"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-4 py-6 text-center">
                                            No hay préstamos registrados.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- Paginación --}}
                        <div class="mt-4">
                            {{ $insumos->links() }}
                        </div>
                    </div>
                @break

                {{-- Rol no reconocido --}}
                @default
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                        <p>Rol no reconocido.</p>
                    </div>
            @endswitch

        </div>
    </div>
</x-app-layout>
