@props([
    'type' => 'info', // success | error | warning | info
    'title' => null,
    'message' => null,
    'show' => true,
    'duration' => 4000,
    'dismissible' => true,
])

@php
    $variant = match ($type) {
        'success' => [
            'ring' => 'border-emerald-200',
            'iconWrap' => 'bg-emerald-50 text-emerald-600',
        ],
        'error' => [
            'ring' => 'border-red-200',
            'iconWrap' => 'bg-red-50 text-red-600',
        ],
        'warning' => [
            'ring' => 'border-amber-200',
            'iconWrap' => 'bg-amber-50 text-amber-600',
        ],
        default => [
            'ring' => 'border-sky-200',
            'iconWrap' => 'bg-sky-50 text-sky-600',
        ],
    };
@endphp

<div class="pointer-events-none fixed right-4 top-4 z-[60] w-full max-w-sm sm:right-6 sm:top-6">
    <div
        x-data="{ open: {{ $show ? 'true' : 'false' }} }"
        x-init="if (open && {{ (int) $duration }} > 0) { setTimeout(() => open = false, {{ (int) $duration }}); }"
        x-show="open"
        x-cloak
        x-transition:enter="transform ease-out duration-200"
        x-transition:enter-start="translate-y-1 opacity-0"
        x-transition:enter-end="translate-y-0 opacity-100"
        x-transition:leave="transform ease-in duration-150"
        x-transition:leave-start="translate-y-0 opacity-100"
        x-transition:leave-end="translate-y-1 opacity-0"
        class="pointer-events-auto rounded-xl border {{ $variant['ring'] }} bg-white p-3 shadow-lg"
        role="status"
        aria-live="polite"
    >
        <div class="flex items-start gap-3">
            <div class="mt-0.5 inline-flex h-7 w-7 shrink-0 items-center justify-center rounded-lg {{ $variant['iconWrap'] }}">
                @if($type === 'success')
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor" class="h-4 w-4" aria-hidden="true"><path d="M229.66,77.66l-128,128a8,8,0,0,1-11.32,0l-56-56a8,8,0,0,1,11.32-11.32L96,188.69,218.34,66.34a8,8,0,0,1,11.32,11.32Z"></path></svg>
                @elseif($type === 'error')
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor" class="h-4 w-4" aria-hidden="true"><path d="M208.49,191.51a12,12,0,0,1-17,17L128,145l-63.52,63.49a12,12,0,0,1-17-17L111,128,47.51,64.49a12,12,0,0,1,17-17L128,111l63.49-63.52a12,12,0,0,1,17,17L145,128Z"></path></svg>
                @elseif($type === 'warning')
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor" class="h-4 w-4" aria-hidden="true"><path d="M236.8,188.09,149.35,36.32a24,24,0,0,0-42.7,0L19.2,188.09A24,24,0,0,0,40,224H216a24,24,0,0,0,20.8-35.91ZM128,104a8,8,0,0,1,8,8v40a8,8,0,0,1-16,0V112A8,8,0,0,1,128,104Zm0,88a12,12,0,1,1,12-12A12,12,0,0,1,128,192Z"></path></svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor" class="h-4 w-4" aria-hidden="true"><path d="M140,180a12,12,0,1,1-12-12A12,12,0,0,1,140,180ZM128,36A92,92,0,1,0,220,128,92.1,92.1,0,0,0,128,36Zm0,168a76,76,0,1,1,76-76A76.08,76.08,0,0,1,128,204Zm-8-100a8,8,0,0,1,16,0v40a8,8,0,0,1-16,0Z"></path></svg>
                @endif
            </div>

            <div class="min-w-0 flex-1">
                @if($title)
                    <p class="text-sm font-semibold text-neutral-800">{{ $title }}</p>
                @endif
                @if($message || trim((string) $slot))
                    <p class="mt-0.5 text-sm text-neutral-600">{{ $message ?: $slot }}</p>
                @endif
            </div>

            @if($dismissible)
                <button
                    type="button"
                    class="inline-flex h-6 w-6 items-center justify-center rounded-md text-neutral-400 hover:bg-neutral-100 hover:text-neutral-600"
                    @click="open = false"
                    aria-label="Cerrar notificación"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor" class="h-3.5 w-3.5" aria-hidden="true"><path d="M205.66,194.34a8,8,0,0,1-11.32,11.32L128,139.31,61.66,205.66a8,8,0,0,1-11.32-11.32L116.69,128,50.34,61.66A8,8,0,0,1,61.66,50.34L128,116.69l66.34-66.35a8,8,0,0,1,11.32,11.32L139.31,128Z"></path></svg>
                </button>
            @endif
        </div>
    </div>
</div>
