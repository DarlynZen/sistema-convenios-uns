@component('layouts.app')
@slot('header')
@endslot

<div class="antialiased font-sans">
    <div class="text-black/50">

        <div class="w-full h-full">
            <div class="relative h-72 h-sm-80 overflow-hidden">
                <div class="absolute inset-0 z-10 flex flex-col justify-end items-start py-10 lg:px-28 px-3">
                    <p class="text-2xl font-bold text-neutral-50">
                        {{ $heroTitulo ?? 'Convenios y Alianzas' }}
                    </p>
                    <p class="text-base text-neutral-50 font-normal mt-2">
                        {{ $heroSubtitulo ?? 'Descubre nuestras colaboraciones para enriquecer tu experiencia educativa' }}
                    </p>
                </div>
                <img class="w-full h-full object-cover object-top brightness-75"
                    src="{{ $heroImagenUrl ?? asset('assets/images/portada.jpg') }}" alt="Portada" />
            </div>

            {{-- Tabs de navegación --}}
            <div class="w-full">
                <div class="mb-4 border-b bg-brand-50 xl:px-28">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-styled-tab"
                        data-tabs-toggle="#default-styled-tab-content"
                        data-tabs-active-classes="text-neutral-50 hover:text-neutral-50 border-[#D9324D] bg-[#D9324D]"
                        data-tabs-inactive-classes="text-[#393939] hover:text-[#D9324D] hover:border-[#D9324D]"
                        role="tablist">
                        <li class="me-1.5" role="presentation">
                            <button class="inline-block p-4 border-b-2" id="informacion-general-tab"
                                data-tabs-target="#informacion-general" data-tab="inicio" type="button" role="tab"
                                aria-selected="false">Información general</button>
                        </li>
                        <li class="me-1.5" role="presentation">
                            <button class="inline-block p-4 border-b-2" id="nuestros-convenios-tab"
                                data-tabs-target="#nuestros-convenios" data-tab="nuestros-convenios" type="button"
                                role="tab" aria-selected="false">Nuestros
                                convenios</button>
                        </li>
                        <li class="me-1.5" role="presentation">
                            <button class="inline-block p-4 border-b-2" id="nosotros-tab"
                                data-tabs-target="#nosotros" data-tab="nosotros" type="button" role="tab"
                                aria-selected="false">Nosotros</button>
                        </li>
                        <li class="me-1.5" role="presentation">
                            <button class="inline-block p-4 border-b-2" id="noticias-tab"
                                data-tabs-target="#noticias" data-tab="noticias" type="button" role="tab"
                                aria-selected="false">Noticias</button>
                        </li>
                    </ul>
                </div>
                <input type="hidden" id="serverTab" value="{{ $tab }}">
                <div id="default-styled-tab-content" class="xl:px-24 py-5">
                    {{-- Información general (visible por defecto) --}}
                    <div id="informacion-general" role="tabpanel" aria-labelledby="informacion-general-tab"
                        class="bg-gray-50 px-4">
                        @includeIf('site.convenios.tabs.informacion-general')
                    </div>

                    {{-- Nuestros convenios --}}
                    <div id="nuestros-convenios" role="tabpanel" aria-labelledby="nuestros-convenios-tab"
                        class="hidden bg-gray-50 px-4">
                        @includeIf('site.convenios.tabs.nuestros-convenios')
                    </div>

                    {{-- Nosotros --}}
                    <div id="nosotros" role="tabpanel" aria-labelledby="nosotros-tab"
                        class="hidden bg-gray-50 px-4">
                        @includeIf('site.convenios.tabs.nosotros')
                    </div>

                    {{-- Noticias --}}
                    <div id="noticias" role="tabpanel" aria-labelledby="noticias-tab"
                        class="hidden bg-gray-50 px-4">
                        @includeIf('site.convenios.tabs.noticias')
                    </div>
                </div>
            </div>

            <footer class="bg-[#393939] inset-x-0 bottom-0 w-full">
                <div class="w-full px-3 py-6 md:px-12 lg:px-24">
                    <div class="grid grid-cols-1 gap-6 text-center text-xs text-white md:grid-cols-4 md:text-left">
                        <div class="flex flex-col items-center justify-center gap-3 md:col-span-2 md:flex-row md:items-center md:justify-start">
                            <img class="h-16 w-auto sm:h-20 md:h-24" src="{{ asset('assets/images/logo-uns.png') }}" alt="Logo UNS" />
                            <div class="text-xs">
                                <span class="block font-bold uppercase">UNIVERSIDAD NACIONAL DEL SANTA</span>
                                <span class="block">{{ $contactoNombreDireccion ?? '' }}</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-center md:col-span-1 md:justify-start">
                            <div class="text-xs">
                                <span class="block font-bold uppercase">PARA MAYOR INFORMACIÓN</span>
                                <div class="flex items-start gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 256 256"><path d="M128,64a40,40,0,1,0,40,40A40,40,0,0,0,128,64Zm0,64a24,24,0,1,1,24-24A24,24,0,0,1,128,128Zm0-112a88.1,88.1,0,0,0-88,88c0,31.4,14.51,64.68,42,96.25a254.19,254.19,0,0,0,41.45,38.3,8,8,0,0,0,9.18,0A254.19,254.19,0,0,0,174,200.25c27.45-31.57,42-64.85,42-96.25A88.1,88.1,0,0,0,128,16Zm0,206c-16.53-13-72-60.75-72-118a72,72,0,0,1,144,0C200,161.23,144.53,209,128,222Z"></path></svg>
                                    <span class="block min-w-0 flex-1">
                                        <span class="block">{{ $contactoUbicacion ?? '' }}</span>
                                    </span>
                                </div>
                                <div class="flex items-start gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 256 256" class="mt-0.5 shrink-0 flex-none">
                                        <path d="M222.37,158.46l-47.11-21.11-.13-.06a16,16,0,0,0-15.17,1.4,8.12,8.12,0,0,0-.75.56L134.87,160c-15.42-7.49-31.34-23.29-38.83-38.51l20.78-24.71c.2-.25.39-.5.57-.77a16,16,0,0,0,1.32-15.06l0-.12L97.54,33.64a16,16,0,0,0-16.62-9.52A56.26,56.26,0,0,0,32,80c0,79.4,64.6,144,144,144a56.26,56.26,0,0,0,55.88-48.92A16,16,0,0,0,222.37,158.46ZM176,208A128.14,128.14,0,0,1,48,80,40.2,40.2,0,0,1,82.87,40a.61.61,0,0,0,0,.12l21,47L83.2,111.86a6.13,6.13,0,0,0-.57.77,16,16,0,0,0-1,15.7c9.06,18.53,27.73,37.06,46.46,46.11a16,16,0,0,0,15.75-1.14,8.44,8.44,0,0,0,.74-.56L168.89,152l47,21.05h0s.08,0,.11,0A40.21,40.21,0,0,1,176,208Z"></path>
                                    </svg>
                                    <span class="block">{{ $contactoTelefono ?? '' }}</span>
                                </div>
                                <div class="flex items-start gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 256 256" class="mt-0.5 shrink-0 flex-none">
                                        <path d="M224,48H32a8,8,0,0,0-8,8V192a16,16,0,0,0,16,16H216a16,16,0,0,0,16-16V56A8,8,0,0,0,224,48Zm-96,85.15L52.57,64H203.43ZM98.71,128,40,181.81V74.19Zm11.84,10.85,12,11.05a8,8,0,0,0,10.82,0l12-11.05,58,53.15H52.57ZM157.29,128,216,74.18V181.82Z"></path>
                                    </svg>
                                    <span class="block">{{ $contactoCorreo ?? '' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-center md:col-span-1 md:justify-start">
                            <div class="text-xs">
                                <span class="block font-bold uppercase">Administración</span>
                                @guest
                                @if (Route::has('login'))
                                <a
                                    href="{{ route('login') }}"
                                    class="mt-2 inline-flex items-center justify-center gap-2 rounded-md bg-white/10 px-4 py-2 text-xs font-bold text-white ring-1 ring-white/20 transition hover:bg-white/15 hover:ring-white/30 focus:outline-none focus:ring-2 focus:ring-white/30">
                                    Acceso administrativo
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 17L17 7M7 7h10v10" />
                                    </svg>
                                </a>
                                @endif
                                @endguest
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full border-t-[0.1px] border-[#8a8888]">
                    <div class="px-3 py-6 text-center text-xs text-white md:px-28">
                        &copy; {{ date('Y') }} Dirección de Cooperación Técnica e Intercambio Académico -
                        Universidad Nacional del Santa.
                    </div>
                </div>
            </footer>
        </div>
    </div>
</div>
@endcomponent

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabsList = document.getElementById('default-styled-tab');
        const tabs = Array.from(document.querySelectorAll('[role="tab"]'));
        const panels = Array.from(document.querySelectorAll('[role="tabpanel"]'));

        // leer clases activas/inactivas desde data-attributes (como usa Flowbite)
        const activeClasses = (tabsList.dataset.tabsActiveClasses || '').split(' ').filter(Boolean);
        const inactiveClasses = (tabsList.dataset.tabsInactiveClasses || '').split(' ').filter(Boolean);

        function applyClasses(el, classes, remove = false) {
            classes.forEach(cls => {
                if (!cls) return;
                if (remove) el.classList.remove(cls);
                else el.classList.add(cls);
            });
        }

        function setActiveTab(tab) {
            tabs.forEach(t => {
                const panelSelector = t.getAttribute('data-tabs-target');
                const panel = document.querySelector(panelSelector);

                if (t === tab) {
                    t.setAttribute('aria-selected', 'true');
                    applyClasses(t, inactiveClasses, true);
                    applyClasses(t, activeClasses, false);
                    if (panel) panel.classList.remove('hidden');
                } else {
                    t.setAttribute('aria-selected', 'false');
                    applyClasses(t, activeClasses, true);
                    applyClasses(t, inactiveClasses, false);
                    if (panel) panel.classList.add('hidden');
                }
            });
        }

        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const tabName = this.dataset.tab;
                const baseUrl = window.location.pathname;
                history.replaceState(null, '', baseUrl + '?tab=' + tabName);
            });
        });

        const serverTab = document.getElementById('serverTab')?.value;
        const matchingTab = tabs.find(t => t.dataset.tab === serverTab);
        const tabToActivate = matchingTab || tabs[0];

        setActiveTab(tabToActivate);
    });
</script>