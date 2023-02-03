<x-app-layout>    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Task detail') }}
        </h2>
    </x-slot>

    <x-card>
        <div class="flex flex-row justify-between">
            <div class="flex-col w-1/3">                
                <div>
                    <x-label :value="__('Project title')" />
                    {{ $task->project->title }}
                </div>                
                <div class="mt-4">
                    <x-label :value="__('User')" />
                    {{ $task->user->name }}
                </div>                
                <div class="mt-4">
                    <x-label :value="__('Task description')" />
                    {{ $task->description }}
                </div>                
            </div>
            <div class="flex-col w-1/3">
                <div>
                    <x-label :value="__('Client Name')" />
                    {{ $task->client->name }}
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
            
            @if($task->status != 'close')
            <x-anchor href="{{ route('tasks.edit', $task->id) }}">Edit task</x-anchor>            
            <form action="{{ route('task.complete', $task->id) }}" method="POST">
                @csrf
                @method('put')
                <x-button>{{ __('Complete task') }}</x-button>
            </form>
            @endif
            
        </x-card-footer>
    </x-card>

    <div class="flex flex-col gap-6 md:flex-row pt-6">
        <x-card>
            
        </x-card>
        <x-card>
            
        </x-card>
    </div>

</x-app-layout>