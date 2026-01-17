<div class="text-neutral-600 h-full py-2 space-y-3">
    <div class="w-full max-w-6xl mx-auto">
        <div class="py-2">
            <h2 class="font-extrabold text-lg">Todos nuestros convenios</h2>
        </div>

        <form method="GET" action="{{ url('/inicio') }}" class="w-full">
            <input type="hidden" name="tab" value="nuestros-convenios">

            <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center">
                {{-- Buscador --}}
                <div class="md:col-span-6">
                    <label for="buscar_convenio" class="sr-only">Buscar convenio</label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-4 w-4 text-neutral-400" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                <path d="M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" stroke="currentColor" stroke-width="2"/>
                            </svg>
                        </div>
                        <input
                            id="buscar_convenio"
                            name="q"
                            type="text"
                            value="{{ request('q') }}"
                            placeholder="Buscar convenio"
                            class="w-full rounded border border-neutral-300 bg-white py-2 pl-10 pr-3 text-sm text-neutral-700 placeholder:text-neutral-400 focus:border-neutral-400 focus:ring-neutral-600"
                        >
                    </div>
                </div>

                {{-- Filtro por tipo --}}
                <div class="md:col-span-3">
                    <label for="tipo" class="sr-only">Seleccionar tipo</label>
                    <div class="relative">
                        <select
                            id="tipo"
                            name="tipo"
                            class="w-full appearance-none rounded border border-neutral-300 bg-white py-2 pl-3 pr-10 text-sm text-neutral-700 focus:border-neutral-400 focus:ring-neutral-600"
                        >
                            <option value="">Seleccionar tipo</option>

                            @isset($tiposConvenio)
                                @foreach($tiposConvenio as $tipo)
                                    <option value="{{ $tipo->id }}" @selected((string) request('tipo') === (string) $tipo->id)>
                                        {{ $tipo->nombre }}
                                    </option>
                                @endforeach
                            @else
                                <option value="marco" @selected(request('tipo') === 'marco')>Convenio marco</option>
                                <option value="especifico" @selected(request('tipo') === 'especifico')>Convenio específico</option>
                            @endisset
                        </select>

                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                            <svg class="h-4 w-4 text-neutral-400" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Botones --}}
                <div class="md:col-span-3">
                    <div class="flex gap-2">
                        <button
                            type="submit"
                            class="flex-1 rounded bg-[#D82F4B] px-4 py-2 text-sm font-medium text-white hover:bg-[#D42340] focus:outline-none focus:ring-2 focus:ring-[#D82F4B] focus:ring-offset-2 transition"
                        >
                            Buscar
                        </button>

                        <a
                            href="{{ url('/inicio?tab=nuestros-convenios') }}"
                            class="flex-1 rounded border border-neutral-300 bg-white px-4 py-2 text-center text-sm font-medium text-neutral-700 hover:bg-neutral-50 focus:outline-none focus:ring-2 focus:ring-neutral-400 focus:ring-offset-2 transition"
                        >
                            Limpiar filtros
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
