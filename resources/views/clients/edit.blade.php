<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Client edit') }}
        </h2>
    </x-slot>

    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <form action="{{ route('clients.update', $client->id) }}" method="POST">
        @csrf
        @method('put')

    <x-card>
        
        <div>
            <x-label for="name" :value="__('Name')" />
            <x-input id="name" class="block mt-1 w-1/3" 
                type="text" 
                name="name" 
                :value="old('name', $client->name)" 
                required autofocus 
            />
        </div>

        <div class="mt-4">
            <x-label for="address" :value="__('Adress')" />
            <x-textarea id="address" rows="6" class="block mt-1 w-1/3" 
                name="address"
                required autofocus 
            >{{ old('address', $client->address) }}
            </x-textarea>
        </div>

        <div class="mt-4">
            <x-label for="vat" :value="__('VAT')" />
            <x-input id="vat" class="block mt-1 w-1/3" 
                type="text" 
                name="vat" 
                :value="old('vat', $client->vat)" 
                required autofocus 
            />
        </div>

        <x-card-footer>
            <x-anchor href="{{ route('clients.index') }}">Back</x-anchor>
            <x-button>{{ __('Save') }}</x-button>
        </x-card-footer>

        
    </x-card>
    </form>
</x-app-layout>