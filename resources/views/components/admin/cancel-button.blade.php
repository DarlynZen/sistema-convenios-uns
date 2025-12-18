<button {{ $attributes->merge(['type' => 'button', 'class' => 'flex flex-row items-center gap-2 bg-white text-neutral-600 px-4 py-2 text-sm rounded border border-neutral-400 hover:bg-neutral-200 transition-colors duration-300']) }}>
    {{ $slot }}
</button>
