<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Archived Clients') }}
        </h2>
    </x-slot>
    
    <x-card>            
        <div>
            <div class="flex flex-col justify-between gap-2 md:flex-row gap-4"> 
                <div class="flex gap-1">
                    <x-anchor href="{{ route('clients.index') }}">{{ __('back to clients') }}</x-anchor>
                </div>
                <form action="{{ route('clients.index') }}">                        
                    <x-input id="search" class="block mt-1 w-full" type="text" name="search" placeholder="{{ __('Search...') }}" :value="request('search')" autofocus />
                </form>
            </div>              
        </div>
    </x-card>    

    <x-card-table>        
        <x-table :cols="['#', 'Company & VAT Address', 'Projects', 'Users', 'Tasks']">
            @foreach ($clients as $client)
                <x-table-row 
                :model="$client"
                :data="[
                    $i+$loop->iteration, 
                    [$client->name, $client->full_address], 
                    $client->projects_count,
                    $client->unique_users_count,
                    $client->tasks_count,
                ]"
                :options="[
                    'restore' => route('client.restore', $client->id),
                    'delete' => route('client.forceDelete', $client->id),
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