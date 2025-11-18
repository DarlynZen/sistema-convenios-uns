<aside id="sidebar" class="w-64 h-full bg-neutral-100 z-40 transform transition-transform duration-300 flex-shrink-0 overflow-y-auto -translate-x-full absolute left-0 top-0 lg:translate-x-0 lg:relative lg:left-auto lg:top-auto">
    <!-- Principal -->
    <div class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase">
        Principal
    </div>

    <ul class="mb-4 px-4">
        <li>
            <a href="{{ route('admin.dashboard') }}"
                class="sidebar-item flex flex-row {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7m-9-5v12" />
                </svg>
                <span>Dashboard</span>
            </a>
        </li>
    </ul>

    <!-- Gestión -->
    <div class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase">
        Gestión
    </div>

    <ul class="mb-4 px-4 space-y-2">
        <li>
            <a href="{{ route('admin.convenios') }}"
                class="sidebar-item flex flex-row {{ request()->routeIs('admin.convenios') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>Convenios</span>
            </a>
        </li>

        <li>
            <a href="{{ route('admin.cms') }}"
                class="sidebar-item flex flex-row {{ request()->routeIs('admin.cms') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                <span>Editor de Contenido</span>
            </a>
        </li>

    </ul>
</aside>

