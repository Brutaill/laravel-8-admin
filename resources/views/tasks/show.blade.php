<x-app-layout>    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Task detail') }}
        </h2>
    </x-slot>

    <x-card>
        <div class="flex flex-col-reverse justify-between gap-4 md:flex-row">
            <div class="flex-col md:w-2/3">                
                <div>
                    <x-label :value="__('Project title')" />
                    <p class="font-semibold">{{ $task->project->title }}</p>
                </div>                
                <div class="mt-4">
                    <x-label :value="__('User')" />
                    {{ $task->user->name }}
                </div>                
                <div class="mt-4">
                    <x-label :value="__('Task description')" />
                    <div class="max-h-48 overflow-y-auto p-2">{{ $task->description }}</div>
                </div>                
            </div>
            <div class="flex-col md:w-1/4">
                <div>
                    <x-label :value="__('Client Name')" />
                    <p class="font-semibold">{{ $task->client->name }}</p>
                </div>
                <div class="mt-4">
                    <x-label for="created_at" :value="__('Created at')" />
                    {{ $task->created_at }}
                </div>
                <div class="mt-4">
                    <x-label for="updated_at" :value="__('Updated at')" />
                    {{ $task->updated_at }}
                </div>                
                <div class="mt-4">
                    <x-label for="completed_at" :value="__('Completed at')" />
                    {{ $task->completed_at }}
                </div>                
            </div>            
        </div>
        <x-card-footer>
            <x-anchor href="{{ route('tasks.index') }}">Back</x-anchor>

            @can('update', $task)            
                @if($task->status != 'close')
                <x-anchor href="{{ route('tasks.edit', $task->id) }}">Edit task</x-anchor>            
                <form action="{{ route('task.complete', $task->id) }}" method="POST">
                    @csrf
                    @method('put')
                    <x-button>{{ __('Complete task') }}</x-button>
                </form>
                @endif
            @endcan
            
        </x-card-footer>
    </x-card>

    <div class="flex flex-col gap-6 md:flex-row pt-6">
        <x-card>
            
        </x-card>
        <x-card>
            
        </x-card>
    </div>

</x-app-layout>