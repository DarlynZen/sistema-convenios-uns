<x-admin-layout>
    <div class="space-y-4">
        <x-admin.block>
            <div class="flex flex-col gap-2">
                <h1 class="text-neutral-600 text-2xl font-bold">Dashboard</h1>
                <p class="text-neutral-600 text-sm">Bienvenido al panel de administración</p>
            </div>
        </x-admin.block>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded p-4 border border-neutral-400">
                <p class="text-sm text-neutral-500">Total convenios</p>
                <p class="mt-1 text-2xl font-bold text-neutral-700">{{ $total_convenios ?? 0 }}</p>
            </div>
            <div class="bg-white rounded p-4 border border-neutral-400">
                <p class="text-sm text-neutral-500">Convenios activos</p>
                <p class="mt-1 text-2xl font-bold text-neutral-700">{{ $convenios_activos ?? 0 }}</p>
            </div>
            <div class="bg-white rounded p-4 border border-neutral-400">
                <p class="text-sm text-neutral-500">Tipos de convenio</p>
                <p class="mt-1 text-2xl font-bold text-neutral-700">{{ $tipos_convenio ?? 0 }}</p>
            </div>
            <div class="bg-white rounded p-4 border border-neutral-400">
                <p class="text-sm text-neutral-500">Ámbitos</p>
                <p class="mt-1 text-2xl font-bold text-neutral-700">{{ $ambitos ?? 0 }}</p>
            </div>
        </div>

        <x-admin.block>
            <div class="w-full">
                <div class="flex items-center justify-between gap-3">
                    <h2 class="text-neutral-700 font-semibold">Convenios recientes</h2>
                    <a href="{{ route('admin.convenios.index') }}" class="text-sm text-brand hover:underline">Ver todos</a>
                </div>

                <div class="mt-3 divide-y divide-neutral-200">
                    @forelse(($recientes ?? []) as $convenio)
                        <div class="py-3 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1">
                            <div>
                                <p class="font-semibold text-neutral-700">
                                    {{ $convenio['titulo'] ?? ('Convenio #' . ($convenio['id'] ?? '')) }}
                                </p>
                                <p class="text-sm text-neutral-500">
                                    {{ $convenio['resolucion'] ?? '' }}
                                    @if (!empty($convenio['tipo'] ?? null))
                                        <span class="text-neutral-400">·</span> {{ $convenio['tipo'] }}
                                    @endif
                                </p>
                            </div>
                            <div class="flex items-center gap-2">
                                <x-admin.badge-estado :estado-id="($convenio['estado_id'] ?? null)" fallback="{{ $convenio['estado'] ?? '' }}" />
                            </div>
                        </div>
                    @empty
                        <div class="py-6 text-sm text-neutral-500">No hay convenios recientes.</div>
                    @endforelse
                </div>
            </div>
        </x-admin.block>
    </div>
</x-admin-layout>
