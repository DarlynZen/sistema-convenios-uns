<?php

namespace App\Services;

use App\Repositories\ConvenioRepository;

class DashboardService
{
    public function __construct(
        private ConvenioRepository $convenioRepository
    ) {}

    /**
     * Obtiene las estadísticas para el dashboard del administrador
     */
    public function getStats(): array
    {
        $stats = $this->convenioRepository->getDashboardStats();

        $recientes = collect($stats['recientes'] ?? [])->map(function ($convenio) {
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
            'total_convenios' => (int) ($stats['total_convenios'] ?? 0),
            'convenios_activos' => (int) ($stats['convenios_activos'] ?? 0),
            'tipos_convenio' => (int) ($stats['tipos_convenio'] ?? 0),
            'ambitos' => (int) ($stats['ambitos'] ?? 0),
            'recientes' => $recientes,
        ];
    }
}

