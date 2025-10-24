<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-sans">
        <div class="text-black/50">
            <div class="relative flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
                <div class="relative w-full h-full">
                    <header class="grid grid-cols-2 bg-[#D82F4B] text-white items-center gap-2 px-5 py-5">
                        <div class="flex justify-start">
                            <img class="ml-3 w-auto h-8" src="{{ asset('images/logo-uns.png') }}" alt="Logo UNS"/>
                        </div>
                        @if (Route::has('login'))
                            <livewire:welcome.navigation />
                        @endif
                    </header>

                    <main class="mt-100 h-screen max-w-6xl mx-auto p-6 lg:p-8">
                        <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
                            
                        </div>
                    </main>

                    <footer class="bg-[#393939] inset-x-0 bottom-0 w-full">
                        <div class=" grid grid-cols-3 p-6 text-center text-xs text-white w-full">
                            <div class="flex flex-row items-center justify-center row-span-3 md:row-span-1">
                                <img class="h-20 w-auto" src="{{ asset('images/logo-uns.png') }}" alt="Logo UNS"/>
                                <div class="text-xs">
                                    <span class="block">UNIVERSIDAD NACIONAL DEL SANTA</span>
                                    <span class="block">Dirección de Cooperación Técnica e Intercambio Académico - DCTIA</span>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 text-center text-xs text-white w-full border-t-[0.1px] border-[#8a8888]">
                            &copy; {{ date('Y') }} Sistema de Gestión de Convenios - Universidad Nacional del Santa.
                        </div>
                    </footer>
                </div>
            </div>
        </div>
    </body>
</html>
