<?php

namespace App\Services;

use App\Repositories\ConvenioRepository;
use Illuminate\Support\Facades\Cache;

class DashboardService
{
    public function __construct(
        private ConvenioRepository $convenioRepository
    ) {}

    public function getStats(int $ttlSeconds = 300): array
    {
        $cached = Cache::remember('dashboard_convenios', $ttlSeconds, function () {
            return [
                'total_convenios' => $this->convenioRepository->contarTotal(),
                'convenios_activos' => $this->convenioRepository->contarActivos(),
                'tipos_convenio' => $this->convenioRepository->contarTipos(),
                'ambitos' => $this->convenioRepository->contarAmbitos(),
                'recientes' => $this->convenioRepository->recientes(5),
            ];
        });

        $recientes = collect($cached['recientes'] ?? [])->map(function ($convenio) {
            return [
                'id' => $convenio->id ?? null,
                'titulo' => $convenio->titulo ?? null,
                'resolucion' => $convenio->resolucion ?? null,
                'tipo' => $convenio->tipoConvenio->nombre ?? null,
                'estado_id' => $convenio->estado_convenio_id ?? null,
                'estado' => $convenio->estadoConvenio->nombre ?? null,
            ];
        })->all();

        return [
            'total_convenios' => (int) ($cached['total_convenios'] ?? 0),
            'convenios_activos' => (int) ($cached['convenios_activos'] ?? 0),
            'tipos_convenio' => (int) ($cached['tipos_convenio'] ?? 0),
            'ambitos' => (int) ($cached['ambitos'] ?? 0),
            'recientes' => $recientes,
        ];
    }
}

