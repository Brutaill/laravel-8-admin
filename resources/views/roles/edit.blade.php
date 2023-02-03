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

    <div class="flex flex-col gap-6 md:flex-row pt-6">

        <x-card>
        <form action="{{ route('role.assignPermissions', $role->id) }}" method="POST">
            @csrf
            @method('put')
        
            <fieldset>
                <legend>{{ __('Permissions') }}</legend>
            @if($permissions)
                <x-checkboxes-multi
                    id="roles_permissions"
                    name="permissions[]"
                    :values="$permissions"
                    :checked="$rolePermissions" 
                />
            @else
                <div>There are no permissions</div>
            @endif
            </fieldset>

            <x-card-footer>
                <x-button type="reset" :flag="'danger'">{{ __('Reset') }}</x-button>
                <x-button>{{ __('Assign permissions') }}</x-button>
            </x-card-footer>

        </form>
        </x-card>

    </div>

</x-app-layout>