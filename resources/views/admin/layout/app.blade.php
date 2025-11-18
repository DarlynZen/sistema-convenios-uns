<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Panel de Administración') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-neutral-100 h-screen flex flex-col overflow-hidden">

    <header class="w-full bg-brand text-white shadow flex items-center justify-between px-4 py-3">
        <div class="flex items-center space-x-3">
            <button id="toggleSidebar" type="button"
                class="p-2 rounded-lg hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-brand-300"
                aria-label="Toggle sidebar">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <span class="text-lg font-semibold">Panel UNS</span>
        </div>
        <img src="{{ asset('assets/images/logo-uns.png') }}" class="h-10" alt="Logo">
        <livewire:layout.navigation />
    </header>

    <div class="flex-1 flex overflow-hidden bg-white relative" style="min-height: 0;">
        <!-- Overlay para mobile -->
        <div id="overlay" class="hidden fixed inset-0 bg-black/40 z-30 lg:hidden transition-opacity duration-300"></div>

        <!-- Sidebar -->
        @include('admin.partials.sidebar')

        <!-- Contenido principal -->
        <main id="content" class="flex-1 overflow-y-auto transition-all duration-300 bg-neutral-300" style="min-width: 0;">
            {{ $slot ?? '' }}
        </main>
    </div>

    @livewireScripts

    <script>
        (function() {
            'use strict';
            
            const DESKTOP = 1024;
            let sidebar = null;
            let overlay = null;
            
            function isMobile() {
                return window.innerWidth < DESKTOP;
            }
            
            function getSidebarState() {
                if (!sidebar) return false;
                if (isMobile()) {
                    return !sidebar.classList.contains("-translate-x-full");
                } else {
                    return !sidebar.classList.contains("hidden");
                }
            }
            
            function initSidebar() {
                sidebar = document.getElementById("sidebar");
                overlay = document.getElementById("overlay");
                
                if (!sidebar) {
                    console.error('Sidebar no encontrado');
                    return false;
                }
                
                if (overlay) overlay.classList.add("hidden");
                
                return true;
            }
            
            function toggleSidebar() {
                if (!sidebar) return;
                
                const isOpen = getSidebarState();
                const mobile = isMobile();
                
                console.log('Toggle - Estado:', isOpen, 'Mobile:', mobile);
                
                if (mobile) {
                    // En mobile, usar translate para mostrar/ocultar
                    if (isOpen) {
                        // Cerrar: agregar translate
                        sidebar.classList.add("-translate-x-full");
                        if (overlay) overlay.classList.add("hidden");
                    } else {
                        // Abrir: quitar translate
                        sidebar.classList.remove("-translate-x-full");
                        if (overlay) overlay.classList.remove("hidden");
                    }
                } else {
                    // En desktop, usar hidden para mostrar/ocultar
                    if (isOpen) {
                        // Cerrar: agregar hidden
                        sidebar.classList.add("hidden");
                    } else {
                        // Abrir: quitar hidden
                        sidebar.classList.remove("hidden");
                    }
                }
            }
            
            // Event listener directo y simple
            function setupToggle() {
                const btn = document.getElementById("toggleSidebar");
                if (btn) {
                    // Remover listeners anteriores si existen
                    const newBtn = btn.cloneNode(true);
                    btn.parentNode.replaceChild(newBtn, btn);
                    
                    newBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        console.log('Botón clickeado');
                        toggleSidebar();
                    });
                    
                    console.log('Toggle button configurado');
                } else {
                    console.error('Botón toggle no encontrado');
                }
            }
            
            // Overlay click
            function setupOverlay() {
                if (overlay) {
                    overlay.addEventListener('click', function(e) {
                        e.preventDefault();
                        if (isMobile()) {
                            sidebar.classList.add("-translate-x-full");
                            overlay.classList.add("hidden");
                        }
                    });
                }
            }
            
            // Inicializar cuando todo esté listo
            function init() {
                if (initSidebar()) {
                    setupToggle();
                    setupOverlay();
                    console.log('Sidebar inicializado correctamente');
                } else {
                    setTimeout(init, 100);
                }
            }
            
            // Iniciar
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', function() {
                    setTimeout(init, 100);
                });
            } else {
                setTimeout(init, 200);
            }
            
            // Reinicializar después de Livewire
            document.addEventListener("livewire:navigated", function() {
                setTimeout(init, 200);
            });
            
            document.addEventListener("livewire:load", function() {
                setTimeout(init, 200);
            });
            
            // Resize handler
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    if (!sidebar) return;
                    
                    const mobile = isMobile();
                    const wasOpen = getSidebarState();
                    
                    if (mobile) {
                        // Cambió a mobile: asegurar que esté en modo absolute
                        // Las clases lg:* se encargan de desktop, solo necesitamos verificar mobile
                        if (wasOpen) {
                            sidebar.classList.remove("-translate-x-full");
                        } else {
                            sidebar.classList.add("-translate-x-full");
                        }
                    } else {
                        // Cambió a desktop: las clases lg:* ya manejan el posicionamiento
                        // Solo manejar hidden si es necesario
                        if (wasOpen) {
                            sidebar.classList.remove("hidden");
                        } else {
                            sidebar.classList.add("hidden");
                        }
                    }
                }, 150);
            });
        })();
    </script>

</body>

</html>