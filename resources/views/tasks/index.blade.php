<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tasks') }}
        </h2>
    </x-slot>
    
    <x-card>            
        <div>
            <div class="flex justify-between">                    
                <x-anchor href="{{ route('tasks.create') }}">{{ __('Create task') }}</x-anchor>
                <form action="{{ route('tasks.index') }}">                        
                    <x-input id="search" class="block mt-1 w-full" type="text" name="search" placeholder="{{ __('Search...') }}" :value="request('search')" autofocus />
                </form>
            </div>              
        </div>
    </x-card>    

    <x-card-table>
        <x-table :cols="['#', 'Project', 'User', 'Description', 'Status']">
            @foreach ($tasks as $task)
                <x-table-row :data="[
                    $i+$loop->iteration,
                    $task->project_title, 
                    $task->user_name, 
                    $task->description,
                    $task->status,
                ]"
                :options="[
                    'show' => route('tasks.show', $task->id),
                    'edit' => route('tasks.edit', $task->id),
                    'delete' => route('tasks.destroy', $task->id),
                    'delete-name' => $task->name,
                ]"
                >
                </x-table-row>
            @endforeach            
        </x-table>
        <x-slot name="links">
            {{ $tasks->links() }}
        </x-slot>
    </x-card-table>

</x-app-layout>