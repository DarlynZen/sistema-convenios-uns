<?php

namespace App\Services;

use App\Repositories\ConvenioRepository;
use App\Models\TipoConvenio;
use App\Models\Ambito;
use App\Models\Convenio;
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
        return [
            'total_convenios' => Convenio::count(),
            'convenios_activos' => Convenio::activos()->count(),
            'tipos_convenio' => TipoConvenio::count(),
            'ambitos' => Ambito::count(),
            'recientes' => $this->convenioRepository->getRecent(5),
        ];
    }
}

