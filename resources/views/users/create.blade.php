<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User create') }}
        </h2>
    </x-slot>

    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

    <x-card>
        
        <div>
            <x-label for="name" :value="__('Name')" />
            <x-input id="name" class="block mt-1 w-1/3" 
                type="text" 
                name="name" 
                :value="old('name')" 
                required autofocus 
            />
        </div>
        
        <div class="mt-4">
            <x-label for="email" :value="__('Email')" />
            <x-input id="email" class="block mt-1 w-1/3" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required autofocus 
            />
        </div>

        <div class="mt-4">
            <x-label for="password" :value="__('Password')" />
            <x-input id="password" class="block mt-1 w-1/3" 
                type="password" 
                name="password" 
                :value="old('password')" 
                required autofocus 
            />
        </div>

        <div class="mt-4">
            <x-label for="password_confirmation" :value="__('Password confirmation')" />
            <x-input id="password_confirmation" class="block mt-1 w-1/3" 
                type="password" 
                name="password_confirmation" 
                :value="old('password_confirmation')" 
                required autofocus 
            />
        </div>

        <div class="mt-4">
            <x-label for="role" :value="__('Role')" />
            <select name="role_id" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}"
                    {{ (old('role_id') == $role->id) ? 'selected' : null }}    
                    >{{ $role->name }}</option>    
                @endforeach
            </select>
        </div>

        <x-card-footer>
            <x-anchor href="{{ route('users.index') }}">Back</x-anchor>
            <x-button>{{ __('Save') }}</x-button>
        </x-card-footer>

        
    </x-card>
    </form>
</x-app-layout>