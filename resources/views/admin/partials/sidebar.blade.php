<aside id="sidebar"
       class="w-56 py-10 h-full bg-neutral-25 z-40 transform transition-transform duration-300 flex-shrink-0 overflow-y-auto -translate-x-full absolute left-0 top-0 lg:translate-x-0 lg:relative">
    <!-- <ul class="mb-4">
        <li>
            <a href="{{ route('admin.dashboard') }}"
                class="sidebar-item flex flex-row {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7m-9-5v12" />
                </svg>
                <span class="text-sm">Dashboard</span>
            </a>
        </li>
    </ul> -->
    <!--     <div class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase">
        Gestión
    </div> -->
    <ul class="space-y-2">
        <li>
            <a href="{{ route('admin.dashboard') }}"
               class="sidebar-item flex flex-row {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                     viewBox="0 0 256 256">
                    <path
                        d="M224,48H32a8,8,0,0,0-8,8V192a16,16,0,0,0,16,16H216a16,16,0,0,0,16-16V56A8,8,0,0,0,224,48ZM203.43,64,128,133.15,52.57,64ZM216,192H40V74.19l82.59,75.71a8,8,0,0,0,10.82,0L216,74.19V192Z"></path>
                </svg>
                <span class="text-sm">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.convenios') }}"
               class="sidebar-item flex flex-row {{ request()->routeIs('admin.convenios') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                     viewBox="0 0 256 256">
                    <path
                        d="M224,48H32a8,8,0,0,0-8,8V192a16,16,0,0,0,16,16H216a16,16,0,0,0,16-16V56A8,8,0,0,0,224,48ZM203.43,64,128,133.15,52.57,64ZM216,192H40V74.19l82.59,75.71a8,8,0,0,0,10.82,0L216,74.19V192Z"></path>
                </svg>
                <span class="text-sm">Convenios</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.cms') }}"
               class="sidebar-item flex flex-row {{ request()->routeIs('admin.cms') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                     viewBox="0 0 256 256">
                    <path
                        d="M224,48H32a8,8,0,0,0-8,8V192a16,16,0,0,0,16,16H216a16,16,0,0,0,16-16V56A8,8,0,0,0,224,48ZM203.43,64,128,133.15,52.57,64ZM216,192H40V74.19l82.59,75.71a8,8,0,0,0,10.82,0L216,74.19V192Z"></path>
                </svg>
                <span class="text-sm">Editor de Contenido</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.catalogo') }}"
               class="sidebar-item flex flex-row {{ request()->routeIs('admin.catalogo') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                     viewBox="0 0 256 256">
                    <path
                        d="M224,48H32a8,8,0,0,0-8,8V192a16,16,0,0,0,16,16H216a16,16,0,0,0,16-16V56A8,8,0,0,0,224,48ZM203.43,64,128,133.15,52.57,64ZM216,192H40V74.19l82.59,75.71a8,8,0,0,0,10.82,0L216,74.19V192Z"></path>
                </svg>
                <span class="text-sm">Catálogo del sistema</span>
            </a>
        </li>
    </ul>
</aside>
