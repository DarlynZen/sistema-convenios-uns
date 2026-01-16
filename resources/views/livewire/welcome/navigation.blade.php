<nav class="flex flex-1 justify-end">
    @if (request()->routeIs('login'))
        <a
            href="{{ url('/') }}"
            class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-white/70"
        >Ir a Página de inicio</a>
    @else
        @auth
            <a
                href="{{ url('/admin/dashboard') }}"
                class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-white/70"
            >Ir al Dashboard</a>
        @endauth
    @endif
</nav>