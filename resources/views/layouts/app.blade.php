<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'DCTIA') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-uns-rojo.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-neutral-50">

        <!-- Page Heading -->
        @if (isset($header))
            <header class="grid grid-cols-2 bg-brand text-neutral-50 items-center gap-2 px-5 py-4">
                <div class="flex justify-start">
                    <img class="ml-3 w-auto h-11" src="{{ asset('images/logo-uns.png') }}" alt="Logo UNS" />
                </div>
                @if (Route::has('login'))
                    <livewire:welcome.navigation />
                @endif
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>
