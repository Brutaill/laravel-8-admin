<x-app-layout>    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Project detail') }}
        </h2>
    </x-slot>

    <x-card>
        <div class="flex flex-row justify-between p-4">
            <div class="flex-col w-2/4">                
                <div>
                    <x-label for="title" :value="__('Title')" />
                    <h2 class="text-lg font-bold">{{ $project->title }}</h2>
                </div>
                <div class="mt-4">
                    <x-label for="description" :value="__('Description')" />
                    {{ $project->description }}
                </div>                
                <div class="mt-8">
                    <x-label for="client" :value="__('Client')" />
                    <h3 class="text-lg font-semibold">{{ $project->client->name }}</h3>
                    <small>{{ $project->client->address }}</small>
                </div>
            </div>
            <div class="flex-col w-1/3">
                <div>
                    <x-label for="created_at" :value="__('Created at')" />
                    {{ $project->created_at }}
                </div>
                <div class="mt-4">
                    <x-label for="updated_at" :value="__('Updated at')" />
                    {{ $project->updated_at }}
                </div>                
                <div class="mt-8">
                    <x-label for="deadline" :value="__('Deadline')" />
                    {{ $project->deadline }}
                </div>
            </div>            
        </div>
        <x-card-footer>
            <x-anchor href="{{ route('projects.index') }}">Back</x-anchor>
            @can('update', $project)
            <x-anchor href="{{ route('projects.edit', $project->id) }}">Edit project</x-anchor>
            @endcan
        </x-card-footer>
    </x-card>

    <div class="flex flex-col gap-6 md:flex-row pt-6">
        <x-card>
        @if(count($tasks))
            @foreach($tasks as $task)
                <div class="flex flex-row gap-3 w-full py-2 border-b border-gray-200">
                    <div>
                        <div class="font-semibold text-lg">
                            <a class="text-blue-500 hover:underline" href="{{ route('tasks.show', $task->id) }}">
                                Task for: {{ $task->user->name }}
                            </a>
                        </div>
                        <div>{{ $task->description }}</div>
                    </div>
                    <div class="whitespace-nowrap">
                        <small>{{ $task->completed_at }}</small>
                    </div>
                </div>
            @endforeach
        @else
            <div>No tasks <x-link href="{{ route('tasks.create', ['project/'.$project->id]) }}">{{ __('Create task') }}</x-link>
            </div>
        @endif
        </x-card>

        <x-card class="w-2/4">
        @if(count($users))
            @foreach($users as $user)
                <div class="flex flex-row gap-3 w-full py-2 border-b border-gray-200">
                    <div class="flex-1 align-left"><x-link href="{{ route('users.show', $user->id) }}">{{ $user->name }}</x-link></div>
                    <div class="flex self-end"><x-link href="mailto:{{ $user->email }}">{{ $user->email }}</x-link></div>
                </div>
            @endforeach
        @else
            <div>No users</div>
        @endif   
        </x-card>
    </div>

</x-app-layout>