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

</head>
<body class=" text-gray-900">
   <div class="bg-white grid grid-cols-3 gap-3 rounded-lg shadow-md items-center">
        <div class=" p-2 rounded-lg">
            <img src="{{ asset('storage/'. $event->images()->first()->image) }}" alt="{{ $user->name }} {{ $user->last_name }}"
                 class="w-48 h-48 object-cover rounded-lg">
        </div>
        <div>
            <h2 class="text-3xl font-semibold text-gray-800">{{ $user->name }} {{ $user->last_name }}</h2>
            <p class="text-sm text-gray-600 mb-2">{{ $user->member_no }}</p>
            <p class="text-sm text-gray-600 mb-2">{{ $user->email }}</p>
            <p class="text-sm text-gray-600 mb-2">{{ $user->phone_number }}</p>
            <p class="text-sm text-gray-600 mb-2">
                Event Date: {{ \Carbon\Carbon::parse($event->date)->format('F j, Y') }}
            </p>
        </div>
        <div class="mt-6">
            <div class="p-6 ">
               <div class="">
                    {!! $qrCode !!}
               </div>
            </div>
        </div>

    </div>
</body>
</html>
