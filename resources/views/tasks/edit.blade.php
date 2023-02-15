<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Task edit') }}
        </h2>
    </x-slot>

    <!-- Validation Errors -->
    <x-card-errors :error=$errors></x-card-errors>

    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
        @csrf
        @method('put')

    <x-card>        
        
        <div class="flex gap-6 w-full">
            <div class="w-full">

                <div>
                    <x-label for="description" :value="__('Description')" />
                    <x-textarea id="description" rows="6" class="block mt-1 w-full" 
                        name="description"
                        required autofocus 
                    >{{ old('description', $task->description) }}
                    </x-textarea>
                </div>

            </div> 
        </div>        

        <x-card-footer>
            <x-anchor href="{{ route('tasks.index') }}">Back</x-anchor>
            <x-button>{{ __('Save') }}</x-button>
        </x-card-footer>

        
    </x-card>
    </form>
</x-app-layout>