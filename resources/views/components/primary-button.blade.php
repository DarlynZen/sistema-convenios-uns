<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-[#D82F4B] border border-transparent rounded font-normal text-xs text-white uppercase tracking-widest hover:bg-[#D42340] focus:bg-[#D42340] active:bg-[#D82F4B] focus:outline-none focus:ring-2 focus:ring-[#D82F4B] focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
