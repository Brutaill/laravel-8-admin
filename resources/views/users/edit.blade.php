<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User edit') }}
        </h2>
    </x-slot>

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('put')

    <x-card>
        
        <div>
            <x-label for="name" :value="__('Name')" />
            <x-input id="name" class="block mt-1 w-1/3" 
                type="text" 
                name="name" 
                :value="old('name', $user->name)" 
                required autofocus 
            />
        </div>
        
        <div class="mt-4">
            <x-label for="email" :value="__('Email')" />
            <x-input id="email" class="block mt-1 w-1/3" 
                type="email" 
                name="email" 
                :value="old('email', $user->email)" 
                required autofocus 
            />
        </div>

        <div class="mt-4">
            <x-label for="role" :value="__('Role')" />
            <select name="role_id" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="">-- select --</option>
                @foreach ($roles as $key => $name)
                    <option value="{{ $key }}"
                    {{ (old('role_id') == $key || in_array($name, $userRoles)) ? 'selected' : null }}    
                    >{{ $name }}</option>    
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