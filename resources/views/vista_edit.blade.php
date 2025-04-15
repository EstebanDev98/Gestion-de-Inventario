<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <form  class="form-control p-6 w-25 m-auto mt-4" action="{{ route('admin.users.edit', $usuario->id) }}" method="POST">
        @csrf
        @method('PUT')
        <p class="titulo-dashboard">Actualizacion de usuario</p>

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

            <x-text-input id="password" class="block mt-1 w-full"
                type="password"
                name="password"
                 autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                type="password"
                name="password_confirmation" autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Campo de Rol -->
        <div>
            <label for="role" class="block text-sm font-medium text-white">Rol</label>
            <select name="role" id="role"
                class="mt-1 block w-full rounded-md bg-gray-900 border-gray-700 text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="Funcionario" selected>Funcionario</option>
                <option value="Supervisor">Supervisor</option>
                <option value="Administrador">Administrador</option>
            </select>
        </div>
        <div class="mt-2">
            <button class="btn btn-primary w-100" type="submit">Actualizar</button>
        </div>

    </form>
</x-app-layout>
