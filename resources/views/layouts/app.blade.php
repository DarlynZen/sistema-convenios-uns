<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'DCTIA') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo-uns-rojo.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-neutral-50">

        <!-- Page Heading -->
        @if (isset($header))
        <header class="grid grid-cols-2 bg-brand text-neutral-50 items-center gap-2 px-5 py-4">
            <div class="flex justify-start">
                <img class="ml-3 w-auto h-11" src="{{ asset('assets/images/logo-uns.png') }}" alt="Logo UNS" />
            </div>
            @if (Route::has('login'))
            <livewire:welcome.navigation />
            @endif
        </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.17/d3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/topojson/1.6.9/topojson.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datamaps/0.5.9/datamaps.world.min.js"></script>

    <script>
        // 1) Lista LATAM (ISO-3)
        const LATAM = new Set([
            "MEX", "GTM", "BLZ", "HND", "SLV", "NIC", "CRI", "PAN",
            "CUB", "DOM", "HTI", "PRI",
            "ARG", "BOL", "BRA", "CHL", "COL", "ECU", "GUY", "PRY", "PER", "SUR", "URY", "VEN"
        ]);

        // 2) Estado global
        let MAP_INSTANCE = null;
        let MAP_MODE = "world"; // "world" | "latam"
        let COUNTRY_DATA = {}; // se llenará desde backend

        function getFillKey(agreements) {
            if (!agreements || agreements <= 0) return "NONE";
            if (agreements <= 2) return "LOW";
            if (agreements <= 5) return "MED";
            return "HIGH";
        }

        function buildDatamapsData(raw) {
            // raw: { PER: { agreements: 3 }, ... }
            const out = {};
            for (const iso3 in raw) {
                const agreements = Number(raw[iso3]?.agreements ?? 0);
                out[iso3] = {
                    agreements,
                    fillKey: getFillKey(agreements),
                };
            }
            return out;
        }

        function renderMap(mode) {
            const el = document.getElementById("hs-users-datamap");
            if (!el) return;

            // Si está oculto (tabs), no renderices aún
            const rect = el.getBoundingClientRect();
            if (rect.width === 0 || rect.height === 0) return;

            // Limpia el contenedor (destroy simple)
            el.innerHTML = "";
            MAP_INSTANCE = null;

            const dataForMap = buildDatamapsData(COUNTRY_DATA);

            // Colores (ajústalos a tu UI)
            const fills = {
                defaultFill: "#E5E7EB",
                NONE: "#E5E7EB",
                LOW: "#BFDBFE",
                MED: "#60A5FA",
                HIGH: "#1D4ED8",
            };

            // Proyección: “enfoque” LATAM vs mundo
            const setProjection = function(element) {
                const width = element.offsetWidth;
                const height = element.offsetHeight;

                const projection = d3.geo.mercator()
                    .scale(mode === "latam" ? (width * 1.1) : (width / 6.2))
                    .translate([width / 2, height / 1.6]);

                if (mode === "latam") {
                    // Ajuste fino para centrar América Latina (tuneable)
                    // translate mueve el mapa; scale agranda/encoge
                    projection
                        .center([-60, -15]) // (lon, lat) aprox
                        .translate([width * 0.55, height * 0.65]);
                }

                const path = d3.geo.path().projection(projection);
                return {
                    projection,
                    path
                };
            };

            MAP_INSTANCE = new Datamap({
                element: el,
                responsive: true,
                fills,
                data: dataForMap,
                setProjection,

                geographyConfig: {
                    borderColor: "rgba(0,0,0,.10)",
                    highlightFillColor: "#F8A3AA",
                    highlightBorderColor: "#D82F4B",
                    popupTemplate: function(geo, data) {
                        const iso3 = geo.id; // ISO-3
                        const isLatam = LATAM.has(iso3);

                        // Si estás en modo LATAM, puedes “desincentivar” hover fuera de LATAM
                        if (mode === "latam" && !isLatam) return null;

                        const agreements = data?.agreements ?? 0;

                        return `
            <div class="bg-white rounded-xl shadow-xl p-3 min-w-[180px]">
              <div class="text-sm font-semibold">${geo.properties.name}</div>
              <div class="text-sm text-gray-700 mt-1">
                Convenios: <span class="font-semibold">${agreements}</span>
              </div>
              <div class="text-xs text-gray-500">${iso3}</div>
            </div>
          `;
                    }
                }
            });

            // Si estás en modo LATAM: “apaga” países fuera de LATAM visualmente
            if (mode === "latam") {
                // Pinta todo el mundo en default, y luego LATAM con su fill real
                const latamOnly = {};
                for (const iso3 in dataForMap) {
                    if (LATAM.has(iso3)) latamOnly[iso3] = dataForMap[iso3];
                }
                MAP_INSTANCE.updateChoropleth(latamOnly, {
                    reset: true
                });
            }

            window.addEventListener("resize", () => MAP_INSTANCE && MAP_INSTANCE.resize());
        }

        async function loadDataFromBackend() {
            // Endpoint que tú crearás en Laravel (abajo te lo dejo)
            const res = await fetch("/admin/convenios/map-data", {
                headers: {
                    "Accept": "application/json"
                }
            });
            const json = await res.json();
            COUNTRY_DATA = json; // formato { PER: { agreements: 3 }, USA: { agreements: 1 } ... }
        }

        async function boot() {
            await loadDataFromBackend();
            renderMap(MAP_MODE);
        }

        document.addEventListener("DOMContentLoaded", () => {
            boot();

            document.getElementById("btn-world")?.addEventListener("click", () => {
                MAP_MODE = "world";
                renderMap(MAP_MODE);
            });

            document.getElementById("btn-latam")?.addEventListener("click", () => {
                MAP_MODE = "latam";
                renderMap(MAP_MODE);
            });

            // Si usas Livewire y cambia el DOM:
            document.addEventListener("livewire:navigated", () => boot());
        });
    </script>

</body>

</html>