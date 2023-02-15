<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Project create') }}
        </h2>
    </x-slot>

    <!-- Validation Errors -->
    <x-card-errors :error=$errors></x-card-errors>

    <form action="{{ route('projects.store') }}" method="POST">
        @csrf

    <x-card>        
        
        <div class="flex gap-6 w-full">
            <div class="w-full">
                <div>
                    <x-label for="title" :value="__('Title*')" />
                    <x-input id="title" class="block mt-1 w-full" 
                        type="text" 
                        name="title" 
                        :value="old('title')" 
                        required autofocus 
                    />
                </div>
        
                <div class="mt-4">
                    <x-label for="description" :value="__('Description*')" />
                    <x-textarea id="description" rows="6" class="block mt-1 w-full" 
                        name="description"
                        required autofocus 
                    >{{ old('description') }}
                    </x-textarea>
                </div>
        
                <div class="mt-4">
                    <x-label for="vat" :value="__('Deadline*')" />
                    <div class="flex gap-4">
                        <x-input type="date" 
                            name="deadline_date" 
                            class="block mt-1 w-full"
                            value="{{ old('deadline_date') }}"
                            min="{{ now()->format('Y-m-d') }}" 
                            placeholder="date" 
                            autocomplete="off" 
                            aria-autocomplete="none" 
                        />
                        <x-input type="time" step="1" 
                            name="deadline_time" 
                            class="block mt-1 w-full"
                            value="{{ old('deadline_time') }}" 
                            placeholder="time" 
                            autocomplete="off" 
                            aria-autocomplete="none" 
                        />
                    </div>            
                </div>
            </div>
            <div class="w-full">
                <div>
                    <x-label for="title">Client*</x-label>
                    <select name="client_id" class="w-full mt-1 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        autocomplete="off" 
                        readonly="readonly"
                        required
                    >
                        <option value="">-- select client --</option>
                        @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                        @endforeach
                    </select>
                </div>
        
                <div class="mt-4">
                    <x-label for="title">Users</x-label>
                    <x-checkboxes-multi
                        id="project_users"
                        :values="$users->pluck('name','id')"    
                        :selected="old('users')"
                        :grouped="false"
                        class="lg:grid-cols-2 xl:grid-cols-1"
                    />
                </div>
            </div>
        </div>        

        <x-card-footer>
            <x-anchor href="{{ route('projects.index') }}">Back</x-anchor>
            <x-button>{{ __('Save') }}</x-button>
        </x-card-footer>

        
    </x-card>
    </form>
</x-app-layout>