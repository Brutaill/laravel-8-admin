<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Projects') }}
        </h2>
    </x-slot>

    <x-card>            
        <div>
            <div class="flex justify-between">                    
                <x-anchor href="{{ route('projects.create') }}">{{ __('Create project') }}</x-anchor>
                <form action="{{ route('projects.index') }}">                        
                    <x-input id="search" class="block mt-1 w-full" type="text" name="search" placeholder="{{ __('Search...') }}" :value="request('search')" autofocus />
                </form>
            </div>              
        </div>
    </x-card>    

    <x-card-table>
        <x-table :cols="['#', 'Title & Description', 'Deadline', 'Tasks', 'Users']">
            @foreach ($projects as $project)
                <x-table-row :data="[
                    $i+$loop->iteration,
                    [$project->title, Str::words($project->description, 5)],                     
                    $project->deadline,
                    $project->tasks_completed_count.'/'.$project->tasks_count,
                    $project->users_count,
                ]"
                :options="[
                    'show' => route('projects.show', $project->id),
                    'edit' => route('projects.edit', $project->id),
                    'delete' => route('projects.destroy', $project->id),
                    'delete-name' => $project->name,
                ]"
                >
                </x-table-row>
            @endforeach            
        </x-table>
        <x-slot name="links">
            {{ $projects->links() }}
        </x-slot>
    </x-card-table>

</x-app-layout>