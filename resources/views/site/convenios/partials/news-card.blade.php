<article class="group w-full max-w-[360px] overflow-hidden rounded-xl border border-neutral-200 bg-white shadow-sm transition duration-500 ease-out hover:-translate-y-0.5 hover:border-neutral-300 hover:shadow-md">
	<a href="{{ $href ?? '#' }}" class="block focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-200 focus-visible:ring-offset-2">
		<div class="relative aspect-[16/10] w-full overflow-hidden bg-neutral-200">
			@if (!empty($image))
				<img
					src="{{ $image }}"
					alt="{{ $title ?? 'Noticia' }}"
					class="h-full w-full object-cover object-center transition-transform duration-500 ease-out group-hover:scale-[1.01]"
					loading="lazy"
				/>
			@else
				<div class="flex h-full w-full items-center justify-center">
					<div class="flex h-14 w-14 items-center justify-center rounded-full bg-neutral-300 text-neutral-600">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-7 w-7">
							<path d="M19.5 6h-15v9h15V6Z" />
							<path fill-rule="evenodd" d="M3 5.25A2.25 2.25 0 0 1 5.25 3h13.5A2.25 2.25 0 0 1 21 5.25v13.5A2.25 2.25 0 0 1 18.75 21H5.25A2.25 2.25 0 0 1 3 18.75V5.25Zm2.25-.75a.75.75 0 0 0-.75.75v13.5c0 .414.336.75.75.75h13.5a.75.75 0 0 0 .75-.75V5.25a.75.75 0 0 0-.75-.75H5.25Z" clip-rule="evenodd" />
						</svg>
					</div>
				</div>
			@endif

			<div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/15 via-transparent to-transparent"></div>

			@if (!empty($category))
				<span class="absolute left-3 top-3 inline-flex items-center rounded bg-white/95 px-2.5 py-1 text-xs font-bold text-neutral-700 ring-1 ring-neutral-200">
					{{ $category }}
				</span>
			@endif
		</div>

		<div class="space-y-3 px-5 py-4">
			<div class="space-y-2">
				<h3 class="text-[15px] font-bold leading-6 tracking-tight text-neutral-800 transition-colors duration-500 ease-out group-hover:text-brand-700 sm:text-base">
					{{ $title ?? '' }}
				</h3>

				@if (!empty($excerpt))
					<p class="text-sm leading-6 text-neutral-600">
						{{ $excerpt }}
					</p>
				@endif
			</div>

			<div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-xs text-neutral-600">
				@if (!empty($date))
					<span class="inline-flex items-center gap-1">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4 text-neutral-500">
							<path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3a.75.75 0 0 1 1.5 0v1.5h.75A2.25 2.25 0 0 1 21 6.75v12A2.25 2.25 0 0 1 18.75 21H5.25A2.25 2.25 0 0 1 3 18.75v-12A2.25 2.25 0 0 1 5.25 4.5H6V3a.75.75 0 0 1 .75-.75ZM4.5 9v9.75c0 .414.336.75.75.75h13.5a.75.75 0 0 0 .75-.75V9h-15Z" clip-rule="evenodd" />
						</svg>
						<span>{{ $date }}</span>
					</span>
				@endif

				@if (!empty($author))
					<span class="inline-flex items-center gap-1">
						<span class="font-semibold text-neutral-700">Por:</span>
						<span>{{ $author }}</span>
					</span>
				@endif
			</div>

			@if (!empty($tags))
				<div class="flex flex-wrap gap-2">
					@foreach (($tags ?? []) as $tag)
						<span class="inline-flex items-center rounded bg-white px-2 py-1 text-xs font-semibold text-neutral-700 ring-1 ring-neutral-200">
							{{ $tag }}
						</span>
					@endforeach
				</div>
			@endif

			<div class="pt-1">
				<div class="h-px w-full bg-neutral-300"></div>
			</div>

			<div class="flex items-center justify-between pt-1">
				<span class="text-sm font-semibold text-brand-700 transition-colors duration-500 ease-out group-hover:text-brand-800">Leer más</span>
				<span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-white ring-1 ring-neutral-200 transition-colors duration-500 ease-out group-hover:bg-brand-25 group-hover:ring-brand-200">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4 text-brand-700 transition-colors duration-500 ease-out group-hover:text-brand-800">
						<path stroke-linecap="round" stroke-linejoin="round" d="M7 17L17 7M7 7h10v10" />
					</svg>
				</span>
			</div>
		</div>
	</a>
</article>
