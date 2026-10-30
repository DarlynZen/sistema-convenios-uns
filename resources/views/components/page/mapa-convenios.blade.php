<div class="w-full py-2">
    <section class="rounded border border-neutral-400 bg-neutral-100 p-4 sm:p-5">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div class="space-y-1">
                <h2 class="text-xl font-extrabold text-neutral-600">Tenemos convenios en</h2>
                <p class="text-sm text-neutral-600">Explora la presencia internacional de convenios por país.</p>
            </div>

            <div class="flex items-center gap-2">
                <button
                    id="btn-world"
                    type="button"
                    class="map-mode-btn rounded border border-neutral-400 bg-white px-3 py-2 text-sm font-medium text-neutral-600 transition hover:border-brand hover:bg-brand-25 hover:text-brand"
                    aria-pressed="true"
                >
                    Ver mundo
                </button>

                <button
                    id="btn-latam"
                    type="button"
                    class="map-mode-btn rounded border border-neutral-400 bg-white px-3 py-2 text-sm font-medium text-neutral-600 transition hover:border-brand hover:bg-brand-25 hover:text-brand"
                    aria-pressed="false"
                >
                    Ver LATAM
                </button>
            </div>
        </div>

        <div class="mt-4 rounded border border-neutral-300 bg-white p-2 sm:p-3">
            <div id="hs-users-datamap" class="h-[420px] w-full"></div>
        </div>

        <div class="mt-3 flex flex-wrap items-center gap-3 text-xs text-neutral-600">
            <span class="inline-flex items-center gap-2"><span class="h-2.5 w-2.5 rounded-full bg-neutral-300"></span>Sin convenios</span>
            <span class="inline-flex items-center gap-2"><span class="h-2.5 w-2.5 rounded-full" style="background:#DBE4F2;"></span>1 a 2</span>
            <span class="inline-flex items-center gap-2"><span class="h-2.5 w-2.5 rounded-full" style="background:#7E93B5;"></span>3 a 5</span>
            <span class="inline-flex items-center gap-2"><span class="h-2.5 w-2.5 rounded-full" style="background:#1F2F4A;"></span>6 a más</span>
        </div>
    </section>
</div>
