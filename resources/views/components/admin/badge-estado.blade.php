@props(['estadoId' => null, 'fallback' => ''])

@php
    $label = trim((string) ($slot ?? '')) ?: ($fallback ?: match(@(int)$estadoId) {
        1 => 'Activo',
        2 => 'Vencido',
        3 => 'En Revisión',
        default => 'Desconocido',
    });
@endphp

<span
    x-data="{
        estadoId: {{ json_encode($estadoId) }},
        clases() {
            return {
                'bg-green-100 text-green-700 border border-green-400': this.estadoId === 1,
                'bg-yellow-100 text-yellow-700 border border-yellow-400': this.estadoId === 2,
                'bg-red-100 text-red-700 border border-red-400': this.estadoId === 3,
                'bg-gray-100 text-gray-700 border border-gray-400': ![1,2,3].includes(this.estadoId),
            }
        }
    }"
    :class="clases()"
    class="px-2 py-1 text-xs font-semibold rounded-full inline-flex items-center"
>{{ $label }}</span>
