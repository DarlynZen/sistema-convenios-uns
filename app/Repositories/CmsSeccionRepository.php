<?php

namespace App\Repositories;

use App\Models\CmsSeccion;
use Illuminate\Database\Eloquent\Collection;

class CmsSeccionRepository
{
    /**
     * Obtiene todas las secciones CMS ordenadas por más recientes
     */
    public function getAll(): Collection
    {
        return CmsSeccion::latest()->get();
    }

    /**
     * Busca una sección por su slug
     */
    public function findBySlug(string $slug): ?CmsSeccion
    {
        return CmsSeccion::where('slug', $slug)->first();
    }

    /**
     * Crea una nueva sección CMS
     */
    public function create(array $data): CmsSeccion
    {
        return CmsSeccion::create($data);
    }

    /**
     * Actualiza una sección CMS existente
     */
    public function update(CmsSeccion $seccion, array $data): CmsSeccion
    {
        $seccion->update($data);
        return $seccion->fresh();
    }

    /**
     * Elimina una sección CMS
     */
    public function delete(CmsSeccion $seccion): bool
    {
        return $seccion->delete();
    }
}

