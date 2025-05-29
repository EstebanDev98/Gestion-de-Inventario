<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Bandeja de Insumos') }}
        </h2>
    </x-slot>

    {{-- 1) Insumos Prestados --}}
    <div class="mb-8">
        <h2 class="text-xl font-semibold mb-2">Insumos Prestados</h2>
        @if($prestados->isEmpty())
            <p class="text-gray-600">No hay insumos prestados actualmente.</p>
        @else
            <table class="min-w-full bg-white shadow rounded">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border-b">ID</th>
                        <th class="px-4 py-2 border-b">Nombre</th>
                        <th class="px-4 py-2 border-b">Descripción</th>
                        <th class="px-4 py-2 border-b">Fecha de Préstamo</th>
                        <th class="px-4 py-2 border-b">Responsable</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach($prestados as $insumo)
                        <tr>
                            <td class="px-4 py-2 border-b">{{ $insumo->id }}</td>
                            <td class="px-4 py-2 border-b">{{ $insumo->nombre }}</td>
                            <td class="px-4 py-2 border-b">{{ $insumo->descripcion }}</td>
                            <td class="px-4 py-2 border-b">{{ optional($insumo->fecha_prestamo)->format('d-m-Y') ?? '—' }}</td>
                            <td class="px-4 py-2 border-b">{{ optional($insumo->user)->name ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- 2) Insumos en Bodega (Activo) --}}
    <div class="mb-8">
        <h2 class="text-xl font-semibold mb-2">Insumos en Bodega</h2>
        @if($enBodega->isEmpty())
            <p class="text-gray-600">No hay insumos en bodega actualmente.</p>
        @else
            <table class="min-w-full bg-white shadow rounded">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border-b">ID</th>
                        <th class="px-4 py-2 border-b">Nombre</th>
                        <th class="px-4 py-2 border-b">Descripción</th>
                        <th class="px-4 py-2 border-b">Cantidad</th>
                        <th class="px-4 py-2 border-b">Ubicación</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach($enBodega as $insumo)
                        <tr>
                            <td class="px-4 py-2 border-b">{{ $insumo->id }}</td>
                            <td class="px-4 py-2 border-b">{{ $insumo->nombre }}</td>
                            <td class="px-4 py-2 border-b">{{ $insumo->descripcion }}</td>
                            <td class="px-4 py-2 border-b">{{ $insumo->cantidad }}</td>
                            <td class="px-4 py-2 border-b">{{ $insumo->ubicacion ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- 3) Insumos Agotados --}}
    <div class="mb-8">
        <h2 class="text-xl font-semibold mb-2">Insumos Agotados</h2>
        @if($agotados->isEmpty())
            <p class="text-gray-600">No hay insumos agotados actualmente.</p>
        @else
            <table class="min-w-full bg-white shadow rounded">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border-b">ID</th>
                        <th class="px-4 py-2 border-b">Nombre</th>
                        <th class="px-4 py-2 border-b">Descripción</th>
                        <th class="px-4 py-2 border-b">Última Actualización</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach($agotados as $insumo)
                        <tr>
                            <td class="px-4 py-2 border-b">{{ $insumo->id }}</td>
                            <td class="px-4 py-2 border-b">{{ $insumo->nombre }}</td>
                            <td class="px-4 py-2 border-b">{{ $insumo->descripcion }}</td>
                            <td class="px-4 py-2 border-b">{{ $insumo->updated_at->format('d-m-Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-app-layout>
