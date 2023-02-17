<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <x-card>            
        <div>
            <div class="flex flex-col justify-between gap-2 md:flex-row gap-4"> 
                <div class="flex gap-1">
                @can('user_create')                    
                <x-anchor href="{{ route('users.create') }}">{{ __('Create user') }}</x-anchor>
                @endcan
                </div>
                <form action="{{ route('users.index') }}">                        
                    <x-input id="search" class="block mt-1 w-full" type="text" name="search" placeholder="{{ __('Search...') }}" :value="request('search')" autofocus />
                </form>
            </div>              
        </div>
    </x-card>    

    <x-card-table>
        <x-table :cols="['#', 'Name', 'Email', 'Clients', 'Projects', 'Tasks']">
            @foreach ($users as $user)
                <x-table-row 
                :model="$user"
                :data="[
                    $i+$loop->iteration,
                    $user->name, 
                    $user->email,                     
                    $user->projects->pluck('client_id')->unique()->count(),
                    $user->projects->count(),
                    $user->tasks_count,
                ]"
                :options="[
                    'show' => route('users.show', $user->id),
                    'edit' => route('users.edit', $user->id),
                    'delete' => route('users.destroy', $user->id),
                    'delete-name' => $user->name,
                ]"
                >
                </x-table-row>
            @endforeach            
        </x-table>
        <x-slot name="links">
            {{ $users->links() }}
        </x-slot>
    </x-card-table>

</x-app-layout>