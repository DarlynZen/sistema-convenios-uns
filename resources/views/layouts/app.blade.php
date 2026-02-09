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
            <livewire:welcome.navigation />
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

            const highlightFill = "#F8A3AA";
            const highlightBorder = "#D82F4B";

            const getCountryFillColor = (iso3) => {
                const fillKey = dataForMap[iso3]?.fillKey ?? "NONE";
                return fills[fillKey] ?? fills.defaultFill;
            };

            const buildTooltipHtml = (geo, data) => {
                const agreements = data?.agreements ?? 0;
                return `
            <div style="background:#fff;border-radius:12px;padding:12px;min-width:180px;box-shadow:0 10px 30px rgba(0,0,0,.12);">
              <div style="font-size:14px;font-weight:600;color:#111827;">${geo.properties.name}</div>
              <div style="font-size:14px;color:#374151;margin-top:4px;">
                Convenios: <span style="font-weight:600;">${agreements}</span>
              </div>
              <div style="font-size:12px;color:#6B7280;">${geo.id}</div>
            </div>
          `;
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
                    highlightOnHover: false,
                    popupOnHover: false,
                },
                done: function(map) {
                    const existing = document.getElementById("datamap-tooltip");
                    if (existing) existing.remove();

                    const tooltip = d3.select("body")
                        .append("div")
                        .attr("id", "datamap-tooltip")
                        .style("position", "absolute")
                        .style("z-index", 50)
                        .style("display", "none")
                        .style("pointer-events", "none");

                    map.svg.selectAll(".datamaps-subunit")
                        .on("mouseover", function(geo) {
                            const iso3 = geo.id;
                            const isLatam = LATAM.has(iso3);

                            if (mode === "latam" && !isLatam) {
                                tooltip.style("display", "none");
                                return;
                            }

                            d3.select(this)
                                .style("fill", highlightFill)
                                .style("stroke", highlightBorder)
                                .style("stroke-width", 1);

                            tooltip
                                .html(buildTooltipHtml(geo, dataForMap[iso3]))
                                .style("display", "block");
                        })
                        .on("mousemove", function() {
                            tooltip
                                .style("left", (d3.event.pageX + 12) + "px")
                                .style("top", (d3.event.pageY + 12) + "px");
                        })
                        .on("mouseout", function(geo) {
                            const iso3 = geo.id;
                            d3.select(this)
                                .style("fill", getCountryFillColor(iso3))
                                .style("stroke", "rgba(0,0,0,.10)")
                                .style("stroke-width", null);
                            tooltip.style("display", "none");
                        });
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
