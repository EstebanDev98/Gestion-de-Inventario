<x-app-layout>
    <x-slot name="header">
        <h2 class="font-sans text-2xl text-gray-800 dark:text-gray-200 leading-tight ">
            {{ __('Reportes de inventario') }}
            
        </h2>
    </x-slot>

    <div class="py-0 px-0">
        @livewire('admin.reportes') {{-- Aquí cargas el componente Livewire correctamente --}}
    </div>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</x-app-layout>