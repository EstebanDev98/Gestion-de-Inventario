<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Espacio') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8">
        <form action="{{ route('espacios.update', $espacios->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <x-input-label for="nombre" :value="__('Nombre')" />
                <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" value="{{ old('nombre', $espacios->nombre) }}" required />
                <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="ubicacion" :value="__('Ubicación')" />
                <x-text-input id="ubicacion" name="ubicacion" type="text" class="mt-1 block w-full" value="{{ old('ubicacion', $espacios->ubicacion) }}" required />
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
                <x-primary-button>{{ __('Actualizar') }}</x-primary-button>
            </div>
        </form>
    </div>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</x-app-layout>
