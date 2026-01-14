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
                <div class="grid grid-cols-3 text-center text-xs text-white w-full md:px-24 px-3 py-6">
                    <div class="flex flex-row items-center justify-center row-span-3 md:row-span-1 gap-3">
                        <img class="h-24 w-auto" src="{{ asset('assets/images/logo-uns.png') }}" alt="Logo UNS" />
                        <div class="text-xs text-left">
                            <span class="block font-bold uppercase">UNIVERSIDAD NACIONAL DEL SANTA</span>
                            <span class="block">Dirección de Cooperación Técnica e Intercambio Académico -
                                DCTIA</span>
                        </div>
                    </div>
                    <div class="flex flex-row items-center justify-center row-span-3 md:row-span-1">
                        <div class="text-xs">
                            <span class="block font-bold uppercase">PARA MAYOR INFORMACIÓN</span>
                            <span class="block">Av. Universitaria S/N - Nuevo Chimbote - Campus I - UNS. Rectorado
                                1er piso</span>
                            <span class="block">(+51) 123 456 189</span>
                            <span class="block">oficinaconvenios@uns.edu.pe</span>
                        </div>
                    </div>
                    <div class="flex flex-row items-center justify-center row-span-3 md:row-span-1">
                        <div class="text-xs">
                            <span class="block font-bold uppercase">Administración</span>
                            <span class="block">Acceso administrativo</span>
                        </div>
                    </div>
                </div>
                <div
                    class="p-6 text-center text-xs text-white w-full border-t-[0.1px] border-[#8a8888] md:px-28 px-3 py-6">
                    &copy; {{ date('Y') }} Dirección de Cooperación Técnica e Intercambio Académico -
                    Universidad Nacional del Santa.
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