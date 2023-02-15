<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Task create') }}
        </h2>
    </x-slot>

    <!-- Validation Errors -->
    <x-card-errors :error=$errors></x-card-errors>

    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf

    <x-card>        
        
        <div class="flex gap-6 w-full">
            <div class="w-full">

                <div>
                    <x-label for="title">Projects</x-label>
                    <select name="project_id" class="w-full mt-1 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        autocomplete="off"
                        required
                    >
                        <option value="">-- select project --</option>
                        @foreach($userProjects as $project)
                        <option value="{{ $project->id }}">{{ $project->title }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mt-4">
                    <x-label for="description" :value="__('Description')" />
                    <x-textarea id="description" rows="6" class="block mt-1 w-full" 
                        name="description"
                        required autofocus 
                    >{{ old('description') }}
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