/**
 * Sidebar Manager - Solución simplificada y robusta
 * Maneja la funcionalidad de apertura/cierre del sidebar
 */
(function() {
    'use strict';

    const DESKTOP_BREAKPOINT = 1024;
    
    let sidebar = null;
    let overlay = null;
    let toggleButton = null;

    function isMobile() {
        return window.innerWidth < DESKTOP_BREAKPOINT;
    }

    function isSidebarOpen() {
        if (!sidebar) return false;
        
        if (isMobile()) {
            return !sidebar.classList.contains("-translate-x-full");
        } else {
            return !sidebar.classList.contains("hidden");
        }
    }

    function initializeSidebar() {
        sidebar = document.getElementById("sidebar");
        overlay = document.getElementById("overlay");
        toggleButton = document.getElementById("toggleSidebar");

        if (!sidebar) {
            console.error('[Sidebar] No se encontró el elemento sidebar');
            return false;
        }

        if (!toggleButton) {
            console.error('[Sidebar] No se encontró el botón toggle');
            return false;
        }

        if (isMobile()) {
            sidebar.classList.add("-translate-x-full", "absolute", "left-0", "top-0");
            sidebar.classList.remove("hidden");
            if (overlay) overlay.classList.add("hidden");
        } else {
            sidebar.classList.remove("-translate-x-full", "absolute", "left-0", "top-0", "hidden");
            if (overlay) overlay.classList.add("hidden");
        }

        console.log('[Sidebar] Inicializado correctamente');
        return true;
    }

    function openSidebar() {
        if (!sidebar) return;

        const mobile = isMobile();
        
        if (mobile) {
            sidebar.classList.remove("-translate-x-full");
            if (overlay) overlay.classList.remove("hidden");
        } else {
            sidebar.classList.remove("hidden");
        }

        console.log('[Sidebar] Abierto');
    }

    function closeSidebar() {
        if (!sidebar) return;

        const mobile = isMobile();
        
        if (mobile) {
            sidebar.classList.add("-translate-x-full");
        } else {
            sidebar.classList.add("hidden");
        }

        if (overlay) overlay.classList.add("hidden");
        
        console.log('[Sidebar] Cerrado');
    }

    function toggleSidebar() {
        const currentlyOpen = isSidebarOpen();
        console.log('[Sidebar] Toggle - Estado actual:', currentlyOpen ? 'abierto' : 'cerrado');
        
        if (currentlyOpen) {
            closeSidebar();
        } else {
            openSidebar();
        }
    }

    function handleToggleClick(e) {
        e.preventDefault();
        e.stopPropagation();
        console.log('[Sidebar] Click en botón toggle detectado');
        toggleSidebar();
    }

    function handleOverlayClick(e) {
        if (e.target.id === 'overlay') {
            e.preventDefault();
            closeSidebar();
        }
    }

    function setupEventListeners() {
        document.addEventListener('click', function(e) {
            const target = e.target;
            
            if (target.id === 'toggleSidebar' || target.closest('#toggleSidebar')) {
                handleToggleClick(e);
            }
        }, true);

        if (overlay) {
            overlay.addEventListener('click', handleOverlayClick);
        }

        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                if (!sidebar) return;

                const mobile = isMobile();
                const isAbsolute = sidebar.classList.contains("absolute");
                const wasOpen = isSidebarOpen();

                if (mobile && !isAbsolute) {
                    sidebar.classList.add("absolute", "left-0", "top-0");
                    sidebar.classList.remove("hidden");
                    if (wasOpen) {
                        sidebar.classList.remove("-translate-x-full");
                    } else {
                        sidebar.classList.add("-translate-x-full");
                    }
                } else if (!mobile && isAbsolute) {
                    sidebar.classList.remove("absolute", "left-0", "top-0", "-translate-x-full");
                    if (wasOpen) {
                        sidebar.classList.remove("hidden");
                    } else {
                        sidebar.classList.add("hidden");
                    }
                }
            }, 150);
        });
    }

    function init() {
        const initialized = initializeSidebar();
        if (initialized) {
            setupEventListeners();
        } else {
            // Reintentar después de un breve delay
            setTimeout(init, 200);
        }
    }

    function start() {
        // Esperar a que el DOM esté completamente listo
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(init, 100);
            });
        } else {
            setTimeout(init, 200);
        }
    }

    start();

    document.addEventListener("livewire:navigated", function() {
        console.log('[Sidebar] Livewire navegó, reinicializando...');
        setTimeout(init, 200);
    });

    document.addEventListener("livewire:load", function() {
        console.log('[Sidebar] Livewire cargó, reinicializando...');
        setTimeout(init, 200);
    });

    if (window.Livewire) {
        Livewire.hook('morph.updated', function() {
            console.log('[Sidebar] Livewire actualizó DOM, reinicializando...');
            setTimeout(init, 150);
        });
    }

    window.sidebarToggle = toggleSidebar;
    window.sidebarOpen = openSidebar;
    window.sidebarClose = closeSidebar;

})();
