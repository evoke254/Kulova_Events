<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('style')

</head>
<body class="font-sans text-gray-900 bg-white">
<div class="min-h-screen bg-white dark:bg-gray-800 ">
    <div class="bg-white">
        @include('partials.header')
    </div>
    <x-notifications />
    <x-dialog />
    {{ $slot }}


    @wireUiScripts
    @livewireScripts
    @stack('script')
</div>


</body>
</html>
