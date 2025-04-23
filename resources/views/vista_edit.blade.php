<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
            <form action="{{ route('admin.users.edit', $usuario->id) }}" method="POST">
                @csrf
                @method('PUT')

                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Actualización de usuario</h3>

                <!-- Name -->
                <div class="mb-4">
                    <x-input-label for="name" :value="('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                  :value="old('name', $usuario->name)" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mb-4">
                    <x-input-label for="email" :value="('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                  :value="old('email', $usuario->email)" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <x-input-label for="password" :value="('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                                  autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <x-input-label for="password_confirmation" :value="('Confirm Password')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                                  name="password_confirmation" autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Rol -->
                <div class="mb-6">
                    <label for="role" class="block text-sm font-medium text-gray-700 dark:text-white">Rol</label>
                    <select name="role" id="role"
                            class="mt-1 block w-full rounded-md bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="Funcionario" {{ $usuario->role === 'Funcionario' ? 'selected' : '' }}>Funcionario</option>
                        <option value="Supervisor" {{ $usuario->role === 'Supervisor' ? 'selected' : '' }}>Supervisor</option>
                        <option value="Administrador" {{ $usuario->role === 'Administrador' ? 'selected' : '' }}>Administrador</option>
                    </select>
                </div>

                <!-- Botón -->
                <div class="flex justify-end">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded">
                        Actualizar
                    </button>
                </div>

            </form>
        </div>
    </div>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

</x-app-layout>