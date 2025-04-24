<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <form class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md max-w-md mx-auto mt-6" action="{{ route('admin.users.edit', $usuario->id) }}" method="POST">
        @csrf
        @method('PUT')

        <p class="text-lg font-semibold text-center mb-4 text-gray-800 dark:text-gray-200">Actualización de usuario</p>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $usuario->name)" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $usuario->email)" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Campo de Rol -->
        <div class="mt-4">
            <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rol</label>
            <select name="role" id="role"
                class="mt-1 block w-full rounded-md bg-gray-100 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 text-gray-800 dark:text-white shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                <option value="Funcionario" {{ $usuario->role == 'Funcionario' ? 'selected' : '' }}>Funcionario</option>
                <option value="Supervisor" {{ $usuario->role == 'Supervisor' ? 'selected' : '' }}>Supervisor</option>
                <option value="Administrador" {{ $usuario->role == 'Administrador' ? 'selected' : '' }}>Administrador</option>
            </select>
        </div>

        <!-- Submit Button -->
        <div class="mt-6">
            <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg shadow">
                Actualizar
            </button>
        </div>

    </form>
</x-app-layout>
