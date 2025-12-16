<button {{ $attributes->merge(['type' => 'button', 'class' => 'flex flex-row items-center gap-2 bg-brand-600 text-white px-4 py-2 text-sm rounded hover:bg-brand-700 transition-colors duration-300']) }}>
    {{ $slot }}
</button>
