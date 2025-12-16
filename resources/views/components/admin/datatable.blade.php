@props([
    'columns',
    'rows',
    'actions' => null,
    'emptyState' => 'No hay datos disponibles.',
    'rowKey' => 'id',
])

@php
    $get = fn($row, $key) => data_get($row, $key);
    $isIterable = function($v) { return is_array($v) || $v instanceof \Illuminate\Contracts\Support\Arrayable || $v instanceof \Traversable; };
@endphp

<div class="w-full" x-data>
    <div class="hidden md:block">
        <div class="relative overflow-x-auto bg-white shadow-sm rounded-lg border">
            <table class="w-full text-sm text-left text-body">
                <thead class="text-sm bg-gray-50 border-b">
                    <tr>
                        @foreach($columns as $col)
                            <th class="px-4 py-3 text-gray-600 {{ $col['classes'] ?? '' }}">{{ $col['label'] }}</th>
                        @endforeach
                        @if($actions)
                            <th class="px-4 py-3 text-gray-600">Acciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($rows as $row)
                        <tr class="border-b hover:bg-gray-50">
                            @foreach($columns as $col)
                                @php $val = $get($row, $col['key'] ?? ''); @endphp
                                <td class="px-4 py-3 align-top {{ $col['cellClasses'] ?? '' }}">
                                    @if(isset($col['type']) && $col['type'] === 'image')
                                        @if($val)
                                            <img src="{{ $val }}" alt="" class="w-10 h-10 object-contain" />
                                        @else
                                            -
                                        @endif
                                    @elseif(isset($col['type']) && $col['type'] === 'badge')
                                        @if(isset($col['badgeComponent']) && $col['badgeComponent'])
                                            @includeIf($col['badgeComponent'], ['estadoId' => $val, 'fallback' => $get($row, $col['fallback'] ?? '')])
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">{{ $get($row, $col['fallback'] ?? $col['key']) }}</span>
                                        @endif
                                    @elseif(isset($col['type']) && $col['type'] === 'join')
                                        @php
                                            $pluck = $col['pluck'] ?? null;
                                        @endphp
                                        @if($isIterable($val))
                                            @if($pluck)
                                                {{ is_array($val) ? implode(', ', array_column($val, $pluck)) : $val->pluck($pluck)->join(', ') }}
                                            @else
                                                {{ is_array($val) ? implode(', ', $val) : $val->join(', ') }}
                                            @endif
                                        @else
                                            {{ $val ?? '-' }}
                                        @endif
                                    @else
                                        {{ $val ?? '-' }}
                                    @endif
                                </td>
                            @endforeach

                            @if($actions)
                                <td class="px-4 py-3">
                                    <div class="relative" x-data="{ open: false }">
                                        <button @click="open = !open" class="px-2 py-1 bg-gray-100 rounded text-sm">Acciones</button>

                                        <div x-show="open" @click.outside="open = false" x-transition class="absolute right-0 mt-2 w-40 bg-white border rounded shadow z-50">
                                            @if(is_string($actions))
                                                @includeIf($actions, ['row' => $row])
                                            @elseif(is_array($actions))
                                                <div class="flex flex-col">
                                                    @foreach($actions as $act)
                                                        <button type="button" class="w-full text-left px-3 py-2 text-sm hover:bg-gray-50" @click.prevent="console.log('accion', '{{ addslashes($act['label'] ?? 'Acción') }}', '{{ $get($row, $rowKey) }}')">{{ $act['label'] ?? 'Acción' }}</button>
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="p-2 text-xs text-gray-500">No actions</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($columns) + ($actions ? 1 : 0) }}" class="px-4 py-6 text-center text-gray-500">{{ $emptyState }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="md:hidden space-y-3">
        @forelse($rows as $row)
            <div class="bg-white border rounded-lg p-4 shadow-sm" x-data="{ open: false }">
                <div class="flex justify-between items-start">
                    <div>
                        @php $first = $columns[0] ?? null; @endphp
                        <div class="text-sm font-semibold text-gray-800">{{ $first ? ($get($row, $first['key']) ?? '-') : '' }}</div>
                        <div class="text-xs text-gray-500 mt-1">{{ $columns[2] ? ($get($row, $columns[2]['key']) ?? '') : '' }}</div>
                    </div>

                    <div class="flex items-center gap-2">
                        @if($actions)
                            <div class="relative" x-data="{ openActions: false }">
                                <button @click="openActions = !openActions" class="px-2 py-1 bg-gray-100 rounded text-sm">Acciones</button>
                                <div x-show="openActions" @click.outside="openActions = false" x-transition class="absolute right-0 mt-2 w-40 bg-white border rounded shadow z-50">
                                    @if(is_string($actions))
                                        @includeIf($actions, ['row' => $row])
                                    @elseif(is_array($actions))
                                        <div class="flex flex-col">
                                            @foreach($actions as $act)
                                                <button type="button" class="w-full text-left px-3 py-2 text-sm hover:bg-gray-50" @click.prevent="console.log('accion', '{{ addslashes($act['label'] ?? 'Acción') }}', '{{ $get($row, $rowKey) }}')">{{ $act['label'] ?? 'Acción' }}</button>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="p-2 text-xs text-gray-500">No actions</div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <button @click="open = !open" class="text-sm text-fg-brand">Detalles</button>
                    </div>
                </div>

                <div x-show="open" x-transition class="mt-3 text-sm text-gray-700">
                    @foreach($columns as $col)
                        <div class="flex justify-between py-1 border-b last:border-b-0">
                            <div class="text-xs text-gray-500">{{ $col['label'] }}</div>
                            <div class="text-sm">@php echo ($get($row, $col['key']) ?? '-'); @endphp</div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="text-center text-gray-500">{{ $emptyState }}</div>
        @endforelse
    </div>
</div>
