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
    @wireUiScripts
    @livewireScripts
    @filamentStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('style')
 <style>
        /* Add your animated background styles here */
        body {
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(-45deg, #3498db, #2ecc71);
            background-size: 400% 400%;
            animation: gradientAnimation 10s infinite;
        }

        @keyframes gradientAnimation {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }
    </style>
</head>
<body>
    <div class="text-center grid grid-cols-1">
        <h1 class="text-4xl font-bold mb-4 text-danger-900">Success!</h1>
        <p class="text-lg text-danger-900">{{ $user->name }}</p>
        <p class="text-lg text-danger-900">{{ $event->name }}.</p>
        <!-- Add any additional content or links you need -->
    </div>
</body>

</html>
