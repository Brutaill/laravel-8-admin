<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Archived Projects') }}
        </h2>
    </x-slot>

    <x-card>            
        <div>
            <div class="flex flex-col justify-between gap-2 md:flex-row gap-4"> 
                <div class="flex gap-1">
                    <x-anchor href="{{ route('projects.index') }}">{{ __('Back to projects') }}</x-anchor>
                </div>
                <form action="{{ route('projects.index') }}">                        
                    <x-input id="search" class="block mt-1 w-full" type="text" name="search" placeholder="{{ __('Search...') }}" :value="request('search')" autofocus />
                </form>
            </div>              
        </div>
    </x-card>    

    <x-card-table>
        <x-table :cols="['#', 'Title & Description', 'Deadline', 'Tasks', 'Users']">
            @foreach ($projects as $project)
                <x-table-row 
                :model="$project"
                :data="[
                    $i+$loop->iteration,
                    [$project->title, Str::words($project->description, 5)],                     
                    $project->deadline,
                    $project->tasks_completed_count.'/'.$project->tasks_count,
                    $project->users_count,
                ]"
                :options="[
                    'restore' => route('project.restore', $project->id),
                    'delete' => route('project.forceDelete', $project->id),
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