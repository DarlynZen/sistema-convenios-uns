<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Panel de Administración') }}</title>

    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo-uns-rojo.png') }}" />

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-neutral-200">

    {{-- <livewire:layout.navigation /> --}}

    <div class="h-full flex flex-col w-full">
        <div>
            <header class="bg-white shadow p-4">
                {{ $header ?? '' }}
            </header>
        </div>
        <div>
            @include('admin.partials.sidebar')
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>
