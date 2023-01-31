<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">                   

                    @if(session('success'))
                    <div class="float-right text-sm px-3 py-1 mb-2 rounded bg-green-800 text-white" 
                        x-data="{ show: true }"
                        x-show="show"
                        x-init="setTimeout(() => show = false, 3000)"
                        >
                        {{ session('success') }}
                    </div>
                    @endif

                    {{ $header ?? 'Header' }}
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <x-container>
                {{ $slot ?? 'Slot' }}
                </x-container>
            </main>
        </div>
    </body>
</html>
