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
    @stack('style')

</head>
<body class=" text-gray-900">

<table class="bg-white w-full rounded-lg shadow-md">
    <tr>
        <td class="p-2 rounded-lg">
            <img src="{{ asset('storage/'. $event->images()->first()->image) }}" alt="{{ $user->name }} {{ $user->last_name }}"
                 class="w-48 h-48 object-cover rounded-lg">
        </td>
        <td class="p-4">
            <h2 class="text-3xl font-semibold text-gray-800">{{ $user->name }} {{ $user->last_name }}</h2>
            <p class="text-sm text-gray-600 mb-2">{{ $user->member_no }}</p>
{{--}}            <p class="text-sm text-gray-600 mb-2">{{ $user->email }}</p> --}}
            <p class="text-sm text-gray-600 mb-2">
                Event Date: {{ \Carbon\Carbon::parse($event->date)->format('F j, Y') }}
            </p>
        </td>
        <td class="p-6">
            <div class="">
                {!! $qrCode !!}
            </div>
        </td>
    </tr>
</table>
</body>
</html>
