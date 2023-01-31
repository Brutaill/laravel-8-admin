<x-app-layout>    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User detail') }}
        </h2>
    </x-slot>

    <x-card>
        <div class="flex flex-row justify-between">
            <div class="flex-col w-1/3">
                <div>
                    <x-label for="name" :value="__('Name')" />
                    {{ $user->name }}
                </div>
                <div>
                    <x-label for="email" :value="__('Email')" />
                    {{ $user->email }}
                </div>                
            </div>
            <div class="flex-col w-1/3">
                <div>
                    <x-label for="created_at" :value="__('Created at')" />
                    {{ $user->created_at }}
                </div>
                <div>
                    <x-label for="updated_at" :value="__('Updated at')" />
                    {{ $user->updated_at }}
                </div>                
            </div>            
        </div>
        <x-card-footer>
            <x-anchor href="{{ route('users.index') }}">Back</x-anchor>
        </x-card-footer>
    </x-card>

    <div class="flex flex-col gap-6 md:flex-row pt-6">
        <x-card>
            
        </x-card>
        <x-card>
            
        </x-card>
    </div>

</x-app-layout>