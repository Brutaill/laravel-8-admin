<x-app-layout>    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Role detail') }}
        </h2>
    </x-slot>

    <x-card>
        <div class="flex flex-row justify-between p-4">
            <div class="flex-col w-1/3">                
                <div>
                    <x-label :value="__('Role Name')" />
                    <h2 class="text-lg font-bold">{{ $role->name }}</h2>
                </div>                
                <div class="mt-4">
                    <x-label :value="__('Role guard name')" />
                    {{ $role->guard_name }}
                </div>
            </div>
            <div class="flex-col w-1/3">
                <div class="mt-4">
                    <x-label for="created_at" :value="__('Created at')" />
                    {{ $role->created_at }}
                </div>
                <div class="mt-4">
                    <x-label for="updated_at" :value="__('Updated at')" />
                    {{ $role->updated_at }}
                </div> 
                <div class="mt-4 flex flex-row justify-justify gap-4">
                    <div>
                        <x-label for="updated_at" :value="__('Users')" />
                        <h3 class="text-xl">{{ $role->users->count() }}</h3>
                    </div>
                </div>               
            </div>            
        </div>
        <x-card-footer>
            <x-anchor href="{{ route('roles.index') }}">Back</x-anchor>
            @can('update', $role)
            <x-anchor href="{{ route('roles.edit', $role->id) }}">Edit role</x-anchor>
            @endcan
        </x-card-footer>
    </x-card>

</x-app-layout>