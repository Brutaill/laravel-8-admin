<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Permissions') }}
        </h2>
    </x-slot>

    <x-card>            
        <div>
            <div class="flex justify-between">                    
                <x-anchor href="{{ route('permissions.create') }}">{{ __('Create permission') }}</x-anchor>
                <form action="{{ route('permissions.index') }}">                        
                    <x-input id="search" class="block mt-1 w-full" type="text" name="search" placeholder="{{ __('Search...') }}" :value="request('search')" autofocus />
                </form>
            </div>              
        </div>
    </x-card>    

    <x-card-table>
        <x-table :cols="['#', 'Name', 'Guard name']">
            @foreach ($permissions as $permission)
                <x-table-row :data="[
                    $i+$loop->iteration,
                    $permission->name, 
                    $permission->guard_name,
                ]"
                :options="[
                    //'show' => route('permissions.show', $permission->id),
                    'edit' => route('permissions.edit', $permission->id),
                    'delete' => route('permissions.destroy', $permission->id),
                    'delete-name' => $permission->name,
                ]"
                >
                </x-table-row>
            @endforeach            
        </x-table>
        <x-slot name="links">
            {{ $permissions->links() }}
        </x-slot>
    </x-card-table>

</x-app-layout>