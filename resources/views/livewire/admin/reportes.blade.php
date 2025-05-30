<div class="flex min-h-screen">
    {{-- Sidebar --}}


    <aside class="w-64 h-90 bg-sky-800 ">
        <div class="p-6 border-b">
            <h2 class="text-lg font-bold mb-4 text-sky-300">Panel Reportes</h2>
            <ul class="space-y-2">
                <li>
                    <button wire:click="setSeccion('insumos')" 
                        class="w-full text-left px-4 py-2 rounded 
                        {{ $seccion === 'insumos' ? 'bg-sky-600 text-white font-bold' : 'bg-sky-400 text-white hover:bg-sky-500' }}">
                        📦 Insumos
                    </button></strong> 
                </li>

                <li>
                    <button wire:click="setSeccion('usuarios')" class="w-full text-left text-white px-4 py-2 bg-sky-400         hover:bg-sky-500 rounded">👥 <strong>Usuarios</button></strong>
                </li>

                <li>
                    <button wire:click="setSeccion('estados')" class="w-full text-left text-white px-4 py-2 bg-sky-400         hover:bg-sky-500 rounded">📊 <strong> Estados</button></strong>
                </li>

                <li>
                    <button wire:click="setSeccion('prestamos')" class="w-full text-left text-white px-4 py-2 bg-sky-400         hover:bg-sky-500 rounded"> 📜 <strong>Prestamos</button></strong>
            </ul>

        </div>
        
    </aside>

    {{-- Contenido dinámico --}}
    <div class="flex-1 p-6 bg-gray-50">
        <div class="flex justify-between items-center mb-4">
            <form wire:submit.prevent class="flex items-center space-x-2" >
                <input wire:model.debounce.300ms="busqueda" 
                    type="text" 
                    placeholder="Buscar..." 
                    class="p-2 border border-blue-300 rounded w-80 focus:outline-none focus:ring-2 focus:ring-blue-400" 
                    autofocus>
                
                <button type="submit"
                    class="bg-sky-600 hover:bg-sky-700 text-white px-4 py-2 rounded h-full">Buscar</button>
            </form>
        </div>
        @if ($seccion === 'insumos')
            <h2 class="text-xl font-bold mb-2 dark:text-black">Listado de Insumos</h2>
            @isset($insumos)
                <table class="w-full table-auto border border-gray-300 mt-4 bg-white rounded shadow">
                    <thead class="bg-sky-800 text-white">
                        <tr>
                            <th class="px-4 py-2 text-left" >Nombre</th>
                            <th class="px-4 py-2 text-left" >Código</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($insumos as $insumo)
                            <tr class="border-b hover:bg-sky-100">
                                <td class="px-4 py-2 text-black" >{{ $insumo->nombre }}</td>
                                <td class="px-4 py-2 text-black " >{{ $insumo->codigo_referencia }}</td>
                            </tr>   
                        @endforeach
                    </tbody>
                </table>
            @endisset
        @elseif ($seccion === 'usuarios')
            <h2 class="text-xl font-bold mb-2 dark:text-black">Usuarios Registrados</h2>
            @isset($usuarios)
                <table class="w-full table-auto border border-gray-300 mt-4 bg-white rounded shadow">
                    <thead class="bg-sky-800 text-white"><tr><th>Nombre</th><th>Correo</th></tr></thead>
                    <tbody>
                        @foreach ($usuarios as $usuario)
                            <tr><td class="text-black">{{ $usuario->name }}</td><td class="text-black">{{ $usuario->email }}</td></tr>
                        @endforeach
                    </tbody>
                </table>
            @endisset
        @elseif ($seccion === 'estados')
            <h2 class="text-xl font-bold mb-2 dark:text-black">Estados de Insumos</h2>
            @isset($estados)
                <ul>
                    @foreach ($estados as $estado)
                        <li class= "text-black">{{ $estado->nombre }}: {{ $estado->insumos_count }} insumos</li>
                    @endforeach
                </ul>
            @endisset
        
        @elseif ($seccion === 'prestamos')
            <h2 class="text-xl font-bold mb-2 dark:text-black">Prestamos</h2>
            @isset($prestamos)
                <table class="w-full table-auto border">
                    <thead><tr><th>Nombre</th><th>Fecha de Prestamo</th></tr></thead>
                    <tbody>
                        @foreach ($prestamos as $prestamo)
                            <tr><td>{{ $prestamo->insumo->nombre }}</td><td>{{ $prestamo->fecha_prestamo }}</td></tr>
                        @endforeach
                    </tbody>
                </table>
            @endisset
        @endif

        {{-- Botón de generación de reporte (solo para insumos o usuarios) --}}
        @if ($seccion === 'insumos' || $seccion === 'usuarios' || $seccion === 'prestamos')
            <div class="mt-4">
                <label for="formato" class="block text-sm font-medium text-gray-700">Formato de Reporte:</label>
                <select wire:model="formato" id="formato" class="mt-1 block w-full border-blue-400 rounded-md shadow-sm focus:ring focus:ring-opacity-50 text-blue-500">
                    <option value="" class="text-blue-300">Seleccione un formato</option>
                    <option value="pdf" class="text-blue-300">PDF</option>
                    <option value="excel" class="text-blue-300">Excel</option>
                </select>
            </div>
            <div class="mt-4">
                <label for="fecha_inicio" class="block text-sm font-medium text-gray-700">Fecha de Inicio:</label>
                <input wire:model="fecha_inicio" type="date" id="fecha_inicio" class="mt-1 block w-full border-blue-400 rounded-md shadow-sm focus:ring focus:ring-opacity-50 text-blue-500">
            </div>
            <div class="mt-6">
                <button wire:click="generarReporte"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-md shadow">Generar Reporte
                </button>
                @if (session()->has('error'))   
                    <div class="mt-2 text-red-600 font-medium">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
