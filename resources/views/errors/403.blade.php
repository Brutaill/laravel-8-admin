<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('403 Forbiden') }}
        </h2>
    </x-slot>

    <x-card>
        {{ __('You have no permissions to enter this section/page. Please contact an Administrator.') }}
    </x-card>

</x-app-layout>