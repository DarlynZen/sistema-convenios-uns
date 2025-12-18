<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Panel de Administración') }}</title>

    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo-uns-rojo.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="h-screen flex flex-col overflow-hidden">

    <header class="w-full bg-brand text-white shadow flex items-center justify-between px-4 py-3">
        <div class="flex items-center space-x-3">
            <button id="toggleSidebar" type="button"
                class="p-2 rounded-lg hover:bg-brand-700"
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

    <div class="flex-1 flex overflow-hidden relative" style="min-height: 0;">
        <!-- Overlay para mobile -->
        <div id="overlay" class="hidden fixed inset-0 bg-black/40 z-30 lg:hidden transition-opacity duration-300"></div>

        <!-- Sidebar -->
        @include('admin.partials.sidebar')

        <!-- Contenido principal -->
        <main id="content" class="flex-1 p-8 overflow-y-auto transition-all duration-300 bg-neutral-50" style="min-width: 0;">
            {{ $slot ?? '' }}
        </main>
    </div>

    @livewireScripts

    <script>
        (function() {
            'use strict';
            const DESKTOP = 1024;
            let sidebar, overlay;

            const isMobile = () => window.innerWidth < DESKTOP;
            const getState = () => sidebar && (isMobile() ? !sidebar.classList.contains("-translate-x-full") : !sidebar.classList.contains("hidden"));

            function toggle() {
                if (!sidebar) return;
                const open = getState();
                const mobile = isMobile();

                if (mobile) {
                    sidebar.classList.toggle("-translate-x-full", open);
                    if (overlay) overlay.classList.toggle("hidden", open);
                } else {
                    sidebar.classList.toggle("hidden", open);
                }
            }

            function init() {
                sidebar = document.getElementById("sidebar");
                overlay = document.getElementById("overlay");

                if (!sidebar) {
                    setTimeout(init, 100);
                    return;
                }

                const btn = document.getElementById("toggleSidebar");
                if (btn) {
                    const newBtn = btn.cloneNode(true);
                    btn.replaceWith(newBtn);
                    newBtn.addEventListener('click', (e) => {
                        e.preventDefault();
                        toggle();
                    });
                }

                if (overlay) {
                    overlay.addEventListener('click', () => {
                        if (isMobile() && sidebar) {
                            sidebar.classList.add("-translate-x-full");
                            overlay.classList.add("hidden");
                        }
                    });
                }
            }

            const start = () => {
                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', () => setTimeout(init, 100));
                } else {
                    setTimeout(init, 100);
                }
            };

            start();
            document.addEventListener("livewire:navigated", () => setTimeout(init, 100));
            document.addEventListener("livewire:load", () => setTimeout(init, 100));

            let resizeTimer;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(() => {
                    if (!sidebar) return;
                    const mobile = isMobile();
                    const wasOpen = getState();

                    if (mobile) {
                        sidebar.classList.toggle("-translate-x-full", wasOpen);
                    } else {
                        sidebar.classList.toggle("hidden", wasOpen);
                    }
                }, 150);
            });
        })();
    </script>

</body>

</html>
