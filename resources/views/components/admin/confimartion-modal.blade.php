@props(['name', 'size', 'title' => null, 'icon' => null, 'iconClass' => 'text-brand-500'])

@php
    $sizes = [
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-2xl'
    ];
@endphp

<div
    x-data="{ open: false }"
    x-on:open-modal.window="if ($event.detail === '{{ $name }}') open = true"
    x-on:close-modal.window="open = false"
    x-cloak
>
    <template x-teleport="body">
        <div
            x-show="open"
            class="fixed inset-0 z-[1000] flex items-center justify-center bg-black/50 px-4 py-6"
        >
            <div
                x-show="open"
                x-transition
                @click.outside="open = false"
                class="w-full {{ $sizes[$size] }} rounded-xl bg-white shadow-xl"
            >
                <div class="border-b border-neutral-300 px-6 py-4">
                    <div class="flex items-center gap-2">
                        @if ($icon)
                            @php
                                $iconMarkup = html_entity_decode($icon);
                                $iconMarkup = preg_replace('/\sclass="[^"]*"/i', '', $iconMarkup);
                                $iconMarkup = preg_replace(
                                    '/<svg\b([^>]*)>/i',
                                    '<svg$1 class="h-4 w-4 shrink-0 fill-current text-brand-500">',
                                    $iconMarkup,
                                    1
                                );
                            @endphp
                            <div class="inline-flex shrink-0 items-center justify-center {{ $iconClass }}">
                                {!! $iconMarkup !!}
                            </div>
                        @endif
                        @if ($title)
                            <h3 class="text-sm font-semibold text-neutral-800">{{ $title }}</h3>
                        @endif
                    </div>
                </div>

                <div class="space-y-5 px-6 py-5">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </template>
</div>
