<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Roles') }}
        </h2>
    </x-slot>
    
    <x-card>            
        <div>
            <div class="flex justify-between">           
                @can('role_create')
                <x-anchor href="{{ route('roles.create') }}">{{ __('Create role') }}</x-anchor>
                @endcan
                <form action="{{ route('roles.index') }}">                        
                    <x-input id="search" class="block mt-1 w-full" type="text" name="search" placeholder="{{ __('Search...') }}" :value="request('search')" autofocus />
                </form>
            </div>              
        </div>
    </x-card>    

    <x-card-table>
        <x-table :cols="['#', 'Name', 'Guard name']">
            @foreach ($roles as $role)
                <x-table-row :data="[
                    $i+$loop->iteration,
                    $role->name, 
                    $role->guard_name,
                ]"
                :options="[
                    'show' => route('roles.show', $role->id),
                    'edit' => route('roles.edit', $role->id),
                    'delete' => route('roles.destroy', $role->id),
                    'delete-name' => $role->name,
                ]"
                >
                </x-table-row>
            @endforeach            
        </x-table>
        <x-slot name="links">
            {{ $roles->links() }}
        </x-slot>
    </x-card-table>

</x-app-layout>