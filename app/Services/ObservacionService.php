<?php

namespace App\Services;

use App\Models\Convenio;
use App\Models\Observacion;
use App\Repositories\ObservacionRepository;

class ObservacionService
{
    public function __construct(
        private ObservacionRepository $repository
    ) {}

    /**
     * Crea una nueva observación con lógica de versionado automático
     */
    public function create(Convenio $convenio, array $data): Observacion
    {
        // Calcular la versión si no se proporciona
        if (!isset($data['version'])) {
            $data['version'] = $this->getNextVersion($convenio);
        }

        // Establecer valores por defecto
        $data['convenio_id'] = $convenio->id;
        $data['fecha_creacion'] = now();
        $data['fecha_actualizacion'] = now();

        return $this->repository->create($data);
    }

    /**
     * Actualiza una observación con fecha_actualizacion automática
     */
    public function update(Observacion $observacion, array $data): Observacion
    {
        // Actualizar fecha_actualizacion automáticamente
        $data['fecha_actualizacion'] = now();

        // Si no se proporciona versión, mantener la actual
        if (!isset($data['version'])) {
            $data['version'] = $observacion->version;
        }

        return $this->repository->update($observacion, $data);
    }

    /**
     * Elimina una observación
     */
    public function delete(Observacion $observacion): void
    {
        $this->repository->delete($observacion);
    }

    /**
     * Calcula la próxima versión para un convenio
     */
    private function getNextVersion(Convenio $convenio): int
    {
        $ultimaVersion = $this->repository->getLastVersion($convenio);
        return $ultimaVersion + 1;
    }
}

