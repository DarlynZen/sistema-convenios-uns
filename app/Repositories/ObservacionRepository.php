<?php

namespace App\Repositories;

use App\Models\Observacion;
use App\Models\Convenio;
use Illuminate\Database\Eloquent\Collection;

class ObservacionRepository
{
    /**
     * Obtiene todas las observaciones de un convenio ordenadas por más recientes
     */
    public function getByConvenio(Convenio $convenio): Collection
    {
        return $convenio->observaciones()->latest()->get();
    }

    /**
     * Obtiene una observación con su convenio relacionado
     */
    public function findWithConvenio(int $id): Observacion
    {
        return Observacion::with('convenio')->findOrFail($id);
    }

    /**
     * Obtiene la última versión de observaciones para un convenio
     */
    public function getLastVersion(Convenio $convenio): int
    {
        return $convenio->observaciones()->max('version') ?? 0;
    }

    /**
     * Crea una nueva observación
     */
    public function create(array $data): Observacion
    {
        return Observacion::create($data);
    }

    /**
     * Actualiza una observación existente
     */
    public function update(Observacion $observacion, array $data): Observacion
    {
        $observacion->update($data);
        return $observacion->fresh();
    }

    /**
     * Elimina una observación
     */
    public function delete(Observacion $observacion): bool
    {
        return $observacion->delete();
    }
}

