<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clients') }}
        </h2>
    </x-slot>
    
    <x-card>            
        <div>
            <div class="flex justify-between">                    
                <x-anchor href="{{ route('clients.create') }}">{{ __('Create client') }}</x-anchor>
                <form action="{{ route('clients.index') }}">                        
                    <x-input id="search" class="block mt-1 w-full" type="text" name="search" placeholder="{{ __('Search...') }}" :value="request('search')" autofocus />
                </form>
            </div>              
        </div>
    </x-card>    

    <x-card-table>        
        <x-table :cols="['#', 'Company & VAT Address', 'Projects', 'Users', 'Tasks']">
            @foreach ($clients as $client)
                <x-table-row :data="[
                    $i+$loop->iteration, 
                    [$client->name, $client->full_address], 
                    $client->projects_count,
                    $client->users_count,
                    $client->tasks_count,
                ]"
                :options="[
                    'show' => route('clients.show', $client->id),
                    'edit' => route('clients.edit', $client->id),
                    'delete' => route('clients.destroy', $client->id),
                    'delete-name' => $client->name,
                ]"
                >
                </x-table-row>
            @endforeach            
        </x-table>
        <x-slot name="links">
            {{ $clients->links() }}
        </x-slot>
    </x-card-table>         

</x-app-layout>