<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Role edit') }}
        </h2>
    </x-slot>

    <form action="{{ route('roles.update', $role->id) }}" method="POST">
        @csrf
        @method('put')

    <x-card>
        
        <div>
            <x-label for="name" :value="__('Name')" />
            <x-input id="name" class="block mt-1 w-1/3" 
                type="text" 
                name="name" 
                :value="old('name', $role->name)" 
                required autofocus 
            />
        </div>
        
        <div class="mt-4">
            <x-label for="guard_name" :value="__('Guard name')" />
            <x-input id="guard_name" class="block mt-1 w-1/3" 
                type="text" 
                name="guard_name" 
                :value="old('guard_name', $role->guard_name)" 
                required autofocus 
            />
        </div>

        <x-card-footer>
            <x-anchor href="{{ route('roles.index') }}">Back</x-anchor>
            <x-button>{{ __('Save') }}</x-button>
        </x-card-footer>

        
    </x-card>
    </form>
</x-app-layout>