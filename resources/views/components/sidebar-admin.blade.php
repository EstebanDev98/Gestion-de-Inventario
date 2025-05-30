<aside class="w-64 h-screen bg-white border-r shadow fixed top-0 left-0 z-40">
    <div class="p-6 border-b">
        <h2 class="text-xl font-semibold text-gray-800">Panel Admin</h2>
    </div>
    <nav class="p-4 space-y-2">
        <a href="{{ route('dashboard') }}"
           class="block px-4 py-2 rounded hover:bg-gray-100 text-gray-700">
            🏠 Dashboard
        </a>
        <a href="{{ route('admin.users.index') }}"
           class="block px-4 py-2 rounded hover:bg-gray-100 text-gray-700">
            👥 Gestión de Usuarios
        </a>
        <a href="{{ route('insumos.index') }}"
           class="block px-4 py-2 rounded hover:bg-gray-100 text-gray-700">
            📦 Gestión de Insumos
        </a>
        <a href="{{ route('admin.reportes') }}"
           class="block px-4 py-2 rounded hover:bg-gray-100 text-gray-700">
            📊 Reportes
        </a>
    </nav>
</aside>
