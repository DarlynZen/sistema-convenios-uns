<article class="group w-full max-w-[340px] overflow-hidden rounded border border-neutral-400 bg-[#393939] shadow-sm">
	<div class="relative aspect-[4/5] w-full overflow-hidden bg-neutral-800">
		@if (!empty($image))
		<img
			src="{{ $image }}"
			alt="Foto de {{ $name ?? 'Integrante' }}"
			class="h-full w-full object-cover object-center transition duration-300 group-hover:scale-[1.08]"
			loading="lazy" />
		@else
		<div class="flex h-full w-full items-center justify-center">
			<div class="flex h-20 w-20 items-center justify-center rounded-full bg-neutral-700/60 ring-1 ring-neutral-600/50">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-10 w-10 text-neutral-300">
					<path fill-rule="evenodd" d="M12 2.25a5.25 5.25 0 100 10.5 5.25 5.25 0 000-10.5zM3.75 19.5a8.25 8.25 0 0116.5 0 .75.75 0 01-.75.75h-15a.75.75 0 01-.75-.75z" clip-rule="evenodd" />
				</svg>
			</div>
		</div>
		@endif

		<div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/35 via-black/10 to-transparent"></div>
	</div>

	<div class="space-y-3 px-5 py-4">
		<div class="space-y-1">
			<h3 class="text-lg font-extrabold tracking-tight text-white">
				{{ $name ?? '' }}
			</h3>
			<p class="text-sm font-bold text-[#D9324D]">
				{{ $position }}
			</p>
		</div>

		@if (!empty($description))
		<p class="text-sm leading-6 text-neutral-300">
			{{ $description }}
		</p>
		@endif
		<div class="h-px w-full"></div>
	</div>
</article>