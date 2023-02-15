<x-app-layout>    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Client detail') }}
        </h2>
    </x-slot>

    <x-card>
        <div class="flex flex-row justify-between p-4">
            <div class="flex-col w-1/3">                
                <div>
                    <x-label :value="__('Client Name')" />
                    <h2 class="text-lg font-bold">{{ $client->name }}</h2>
                </div>                
                <div class="mt-4">
                    <x-label :value="__('Client address')" />
                    {{ $client->address }}
                </div>                
                <div class="mt-4">
                    <x-label :value="__('Client VAT')" />
                    {{ $client->vat }}
                </div>                
            </div>
            <div class="flex-col w-1/3">
                <div class="mt-4">
                    <x-label for="created_at" :value="__('Created at')" />
                    {{ $client->created_at }}
                </div>
                <div class="mt-4">
                    <x-label for="updated_at" :value="__('Updated at')" />
                    {{ $client->updated_at }}
                </div> 
                <div class="mt-4 flex flex-row justify-justify gap-4">
                    <div>
                        <x-label for="updated_at" :value="__('Projects')" />
                        <h3 class="text-xl">{{ $client->projects_count }}</h3>
                    </div>
                    <div>
                        <x-label for="updated_at" :value="__('Users')" />
                        <h3 class="text-xl">{{ $client->unique_users_count }}</h3>
                    </div>
                    <div>
                        <x-label for="updated_at" :value="__('Tasks')" />
                        <h3 class="text-xl">{{ $client->tasks_count }}</h3>
                    </div>                    
                </div>               
            </div>            
        </div>
        <x-card-footer>
            <x-anchor href="{{ route('clients.index') }}">Back</x-anchor>
            @can('update', $client)
            <x-anchor href="{{ route('clients.edit', $client->id) }}">Edit client</x-anchor>
            @endcan
        </x-card-footer>
    </x-card>

</x-app-layout>