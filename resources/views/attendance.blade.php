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

<div class="max-w-4xl mx-auto mt-8">
    <div class="bg-white grid grid-cols-1 md:grid-cols-2 gap-3 rounded-lg shadow-md items-center">
        <div class=" p-2 rounded-lg">
            <img src="{{ asset('storage/'. $event->images()->first()->image) }}" alt="{{ $user->name }} {{ $user->last_name }}"
                 class="w-48 h-48 object-cover rounded-lg">
        </div>
        <div>
            <h2 class="text-3xl font-semibold text-gray-800">{{ $user->name }} {{ $user->last_name }}</h2>
            <p class="text-sm text-gray-600 mb-2">{{ $user->member_no }}</p>
            <p class="text-sm text-gray-600 mb-2">{{ $user->email }}</p>
            <p class="text-sm text-gray-600 mb-2">{{ $user->phone_number }}</p>
        </div>
    </div>

    <div class="bg-white grid grid-cols-1 gap-3 rounded-lg shadow-md items-center m-5">
        <div class="px-6 py-4">
            <h2 class="text-2xl text-center mt-5 font-bold">Attendance Logs</h2>
            <ul role="list" class="space-y-6">
                @foreach($attendance as $key => $atnc)

                    @if($atnc->check_in_out)
                        <li class="relative flex gap-x-4">
                            <div class="absolute left-0 top-0 flex w-6 justify-center h-6">
                                <div class="w-px bg-gray-200"></div>
                            </div>
                            <div class="relative flex h-6 w-6 flex-none items-center justify-center bg-white">
                                <x-icon name="badge-check" class="w-10 h-10 text-green-600" />
                            </div>
                            <p class="flex-auto py-0.5 text-green-500"><span class="font-medium text-green-900">{{$user->name}}</span> checked In.</p>
                            <time datetime="2023-01-24T09:20" class="flex-none py-0.5 text-xs leading-5 text-green-900">{{
                                \Carbon\Carbon::parse($atnc->created_at)->format('D, d M Y H:i:s')
                            }}</time>
                        </li>
                    @else
                        <li class="relative flex gap-x-4">
                            <div class="absolute left-0 top-0 flex w-6 justify-center h-6">
                                <div class="w-px bg-gray-200"></div>
                            </div>
                            <div class="relative flex h-6 w-6 flex-none items-center justify-center bg-white">
                                <x-icon name="exclamation-circle" class="w-10 h-10 text-red-600" />
                            </div>
                            <p class="flex-auto py-0.5 text-red-500">Stepped Out.</p>
                            <time datetime="2023-01-24T09:20" class="flex-none py-0.5 text-xs leading-5 text-red-900">{{
                                \Carbon\Carbon::parse($atnc->created_at)->format('D, d M Y H:i:s')
                            }}</time>
                        </li>
                    @endif
                @endforeach


            </ul>
        </div>
    </div>
</div>





</body>
</html>
