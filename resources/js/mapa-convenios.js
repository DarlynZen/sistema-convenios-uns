const LATAM = new Set([
    'MEX', 'GTM', 'BLZ', 'HND', 'SLV', 'NIC', 'CRI', 'PAN',
    'CUB', 'DOM', 'HTI', 'PRI',
    'ARG', 'BOL', 'BRA', 'CHL', 'COL', 'ECU', 'GUY', 'PRY', 'PER', 'SUR', 'URY', 'VEN'
]);

const COUNTRY_NAMES_ES = {
    ARG: 'Argentina',
    BOL: 'Bolivia',
    BRA: 'Brasil',
    CHL: 'Chile',
    COL: 'Colombia',
    ECU: 'Ecuador',
    GTM: 'Guatemala',
    HND: 'Honduras',
    MEX: 'México',
    NIC: 'Nicaragua',
    PAN: 'Panamá',
    PRY: 'Paraguay',
    PER: 'Perú',
    URY: 'Uruguay',
    VEN: 'Venezuela',
    USA: 'Estados Unidos',
    CAN: 'Canadá',
    ESP: 'España',
    FRA: 'Francia',
    DEU: 'Alemania',
    ITA: 'Italia',
    JPN: 'Japón',
    KOR: 'Corea del Sur',
    DOM: 'República Dominicana',
    CUB: 'Cuba',
    HTI: 'Haití',
    PRI: 'Puerto Rico',
    SLV: 'El Salvador',
    CRI: 'Costa Rica',
    GUY: 'Guyana',
    SUR: 'Surinam',
    BLZ: 'Belice',
};

let MAP_INSTANCE = null;
let MAP_MODE = 'world';
let COUNTRY_DATA = {};

function updateModeButtons(activeMode) {
    const buttons = {
        world: document.getElementById('btn-world'),
        latam: document.getElementById('btn-latam'),
    };

    const inactiveClasses = [
        'border-neutral-400', 'bg-white', 'text-neutral-600',
        'hover:border-brand', 'hover:bg-brand-25', 'hover:text-brand'
    ];

    const activeClasses = ['border-brand', 'bg-brand', 'text-white'];

    Object.entries(buttons).forEach(([mode, button]) => {
        if (!button) return;

        button.classList.remove(...inactiveClasses, ...activeClasses);

        if (mode === activeMode) {
            button.classList.add(...activeClasses);
            button.setAttribute('aria-pressed', 'true');
        } else {
            button.classList.add(...inactiveClasses);
            button.setAttribute('aria-pressed', 'false');
        }
    });
}

function getFillKey(agreements) {
    if (!agreements || agreements <= 0) return 'NONE';
    if (agreements <= 2) return 'LOW';
    if (agreements <= 5) return 'MED';
    return 'HIGH';
}

function buildDatamapsData(raw) {
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
    const el = document.getElementById('hs-users-datamap');
    if (!el) return;

    updateModeButtons(mode);

    const rect = el.getBoundingClientRect();
    if (rect.width === 0 || rect.height === 0) return;

    el.innerHTML = '';
    MAP_INSTANCE = null;

    const dataForMap = buildDatamapsData(COUNTRY_DATA);
    const fills = {
        defaultFill: '#eeeded',
        NONE: '#eeeded',
        LOW: '#DBE4F2',
        MED: '#7E93B5',
        HIGH: '#1F2F4A',
    };

    const setProjection = function (element) {
        const width = element.offsetWidth;
        const height = element.offsetHeight;

        const projection = d3.geo.mercator()
            .scale(mode === 'latam' ? (width * 1.1) : (width / 6.2))
            .translate([width / 2, height / 1.6]);

        if (mode === 'latam') {
            projection
                .center([-60, -15])
                .translate([width * 0.55, height * 0.65]);
        }

        return { projection, path: d3.geo.path().projection(projection) };
    };

    const buildTooltipHtml = (geo, data) => {
        const agreements = data?.agreements ?? 0;
        const iso3 = geo.id;
        const countryName = COUNTRY_NAMES_ES[iso3] ?? geo.properties.name;

        return `
            <div style="background:#fff;border-radius:12px;padding:12px;min-width:180px;box-shadow:0 10px 30px rgba(0,0,0,.12);">
              <div style="font-size:14px;font-weight:600;color:#111827;">${countryName}</div>
              <div style="font-size:14px;color:#374151;margin-top:4px;">
                Convenios: <span style="font-weight:600;">${agreements}</span>
              </div>
              <div style="font-size:12px;color:#6B7280;">${iso3}</div>
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
            borderColor: 'rgba(0,0,0,.10)',
            highlightFillColor: '#36507A',
            highlightBorderColor: '#1F2F4A',
            highlightOnHover: false,
            popupOnHover: false,
        },
        done: function (map) {
            const existing = document.getElementById('datamap-tooltip');
            if (existing) existing.remove();

            const tooltip = d3.select('body')
                .append('div')
                .attr('id', 'datamap-tooltip')
                .style('position', 'absolute')
                .style('z-index', 50)
                .style('display', 'none')
                .style('pointer-events', 'none');

            map.svg.selectAll('.datamaps-subunit')
                .on('mouseover', function (geo) {
                    const iso3 = geo.id;
                    const isLatam = LATAM.has(iso3);

                    if (mode === 'latam' && !isLatam) {
                        tooltip.style('display', 'none');
                        return;
                    }

                    const originalFill = dataForMap[iso3]?.fillKey
                        ? fills[dataForMap[iso3].fillKey]
                        : fills.defaultFill;

                    d3.select(this)
                        .style('fill', '#36507A')
                        .style('stroke', '#1F2F4A')
                        .style('stroke-width', 1)
                        .attr('data-original-fill', originalFill);

                    tooltip
                        .html(buildTooltipHtml(geo, dataForMap[iso3]))
                        .style('display', 'block');
                })
                .on('mousemove', function () {
                    tooltip
                        .style('left', (d3.event.pageX + 16) + 'px')
                        .style('top', (d3.event.pageY + 16) + 'px');
                })
                .on('mouseout', function () {
                    const originalFill = d3.select(this).attr('data-original-fill') || fills.defaultFill;
                    d3.select(this)
                        .style('fill', originalFill)
                        .style('stroke', 'rgba(0,0,0,.10)')
                        .style('stroke-width', 1)
                        .attr('data-original-fill', null);
                    tooltip.style('display', 'none');
                });
        }
    });

    if (mode === 'latam') {
        const latamOnly = {};
        for (const iso3 in dataForMap) {
            if (LATAM.has(iso3)) latamOnly[iso3] = dataForMap[iso3];
        }
        MAP_INSTANCE.updateChoropleth(latamOnly, { reset: true });
    }

    window.addEventListener('resize', () => MAP_INSTANCE && MAP_INSTANCE.resize());
}

async function loadDataFromBackend() {
    const res = await fetch('/admin/convenios/map-data', {
        headers: {
            Accept: 'application/json',
        },
    });
    const json = await res.json();
    COUNTRY_DATA = json;
}

async function boot() {
    await loadDataFromBackend();
    renderMap(MAP_MODE);
}

function initMapaConvenios() {
    if (typeof d3 === 'undefined' || typeof Datamap === 'undefined') {
        window.setTimeout(initMapaConvenios, 200);
        return;
    }

    if (window.__MAPA_CONVENIOS_INIT__) {
        return;
    }

    window.__MAPA_CONVENIOS_INIT__ = true;

    boot();

    document.getElementById('btn-world')?.addEventListener('click', () => {
        MAP_MODE = 'world';
        renderMap(MAP_MODE);
    });

    document.getElementById('btn-latam')?.addEventListener('click', () => {
        MAP_MODE = 'latam';
        renderMap(MAP_MODE);
    });

    document.addEventListener('livewire:navigated', () => boot());
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initMapaConvenios);
} else {
    initMapaConvenios();
}

window.addEventListener('load', initMapaConvenios);
