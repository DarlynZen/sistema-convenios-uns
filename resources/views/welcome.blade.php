@component('layouts.app')
    @slot('header')
    @endslot

    <div class="antialiased font-sans">
        <div class="text-black/50">
            <div class="relative flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
                <div class="relative w-full h-full">
                    <header class="grid grid-cols-2 bg-[#D82F4B] text-white items-center gap-2 px-5 py-4">
                        <div class="flex justify-start">
                            <img class="ml-3 w-auto h-11" src="{{ asset('images/logo-uns.png') }}" alt="Logo UNS" />
                        </div>
                        @if (Route::has('login'))
                            <livewire:welcome.navigation />
                        @endif
                    </header>

                    <div class="relative h-72 h-sm-80 overflow-hidden">
                        <div class="absolute inset-0 z-10 flex justify-end py-10 md:px-28 px-3 flex-col w-full h-full">
                            <p class="text-2xl font-bold text-white">
                                Convenios y Alianzas</p>
                            <p class="text-base text-white font-normal">
                                Descubre nuestras colaboraciones para enriquecer tu experiencia educativa</p>
                        </div>
                        <img class="w-full h-full object-cover object-top brightness-75"
                            src="{{ asset('images/portada.jpg') }}" alt="Portada" />
                    </div>

                    <x-page.tabs-navigation />

                    <main class="mt-100 h-screen max-w-6xl mx-auto p-6 lg:p-8">
                        <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">

                        </div>
                    </main>

                    <footer class="bg-[#393939] inset-x-0 bottom-0 w-full">
                        <div class=" grid grid-cols-3 p-6 text-center text-xs text-white w-full">
                            <div class="flex flex-row items-center justify-center row-span-3 md:row-span-1">
                                <img class="h-20 w-auto" src="{{ asset('images/logo-uns.png') }}" alt="Logo UNS" />
                                <div class="text-xs">
                                    <span class="block">UNIVERSIDAD NACIONAL DEL SANTA</span>
                                    <span class="block">Dirección de Cooperación Técnica e Intercambio Académico -
                                        DCTIA</span>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 text-center text-xs text-white w-full border-t-[0.1px] border-[#8a8888]">
                            &copy; {{ date('Y') }} Dirección de Cooperación Técnica e Intercambio Académico -
                            Universidad Nacional del Santa.
                        </div>
                    </footer>
                </div>
            </div>
        </div>
    </div>
@endcomponent
