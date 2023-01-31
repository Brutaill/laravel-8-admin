<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <x-card>            
        <div>
            <div class="flex justify-between">                    
                <x-anchor href="{{ route('users.create') }}">{{ __('Create user') }}</x-anchor>
                <form action="{{ route('users.index') }}">                        
                    <x-input id="search" class="block mt-1 w-full" type="text" name="search" placeholder="{{ __('Search...') }}" :value="request('search')" autofocus />
                </form>
            </div>              
        </div>
    </x-card>    

    <x-card-table>
        <x-table :cols="['#', 'Name', 'Email', 'Projects']">
            @foreach ($users as $user)
                <x-table-row :data="[
                    $i+$loop->iteration,
                    $user->name, 
                    $user->email,                     
                    $user->projects_count,
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