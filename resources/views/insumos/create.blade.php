<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Crear Insumo') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8">
        <form action="{{ route('insumos.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <x-input-label for="nombre" :value="__('Nombre')" />
                <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" required />
                <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="codigo_referencia" :value="__('Código de Referencia')" />
                <x-text-input id="codigo_referencia" name="codigo_referencia" type="text" class="mt-1 block w-full" required />
                <x-input-error :messages="$errors->get('codigo_referencia')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="descripcion" :value="__('Descripción')" />
                <textarea name="descripcion" id="descripcion" rows="3" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="unidad_medida" :value="__('Unidad de Medida')" />
                <x-text-input id="unidad_medida" name="unidad_medida" type="text" class="mt-1 block w-full" required />
                <x-input-error :messages="$errors->get('unidad_medida')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="cantidad" :value="__('Cantidad')" />
                <x-text-input id="cantidad" name="cantidad" type="number" min="0" class="mt-1 block w-full" required />
                <x-input-error :messages="$errors->get('cantidad')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="ubicacion" :value="__('Ubicación')" />
                <x-text-input id="ubicacion" name="ubicacion" type="text" class="mt-1 block w-full" required />
                <x-input-error :messages="$errors->get('ubicacion')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="estado_id" :value="__('Estado')" />
                <select name="estado_id" id="estado_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    @foreach($estados as $estado)
                        <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('estado_id')" class="mt-2" />
            </div>

            <div class="flex justify-end">
                <x-primary-button>{{ __('Guardar') }}</x-primary-button>
            </div>
        </form>
    </div>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</x-app-layout>
