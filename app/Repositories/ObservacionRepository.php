<?php

namespace App\Repositories;

use App\Models\Observacion;
use App\Models\Convenio;
use Illuminate\Database\Eloquent\Collection;

class ObservacionRepository
{

    public function getByConvenio(Convenio $convenio): Collection
    {
        return $convenio->observaciones()->latest()->get();
    }


    public function findWithConvenio(int $id): Observacion
    {
        return Observacion::with('convenio')->findOrFail($id);
    }

    public function getLastVersion(Convenio $convenio): int
    {
        return $convenio->observaciones()->max('version') ?? 0;
    }

    public function create(array $data): Observacion
    {
        return Observacion::create($data);
    }

    public function update(Observacion $observacion, array $data): Observacion
    {
        $observacion->update($data);
        return $observacion->fresh();
    }

    public function delete(Observacion $observacion): bool
    {
        return $observacion->delete();
    }
}