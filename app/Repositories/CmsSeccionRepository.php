<?php

namespace App\Repositories;

use App\Models\CmsSeccion;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

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
     * Obtiene todas las secciones CMS como arrays simples.
     */
    public function getAllArray(): array
    {
        return CmsSeccion::latest()->get()->toArray();
    }

    /**
     * Pagina secciones CMS como array simple (sin exponer el modelo).
     */
    public function paginateArray(int $perPage = 15): array
    {
        /** @var LengthAwarePaginator $paginator */
        $paginator = CmsSeccion::latest()->paginate($perPage);
        return $paginator->toArray();
    }

    /**
     * Busca una sección por su slug
     */
    public function findBySlug(string $slug): ?CmsSeccion
    {
        return CmsSeccion::where('slug', $slug)->first();
    }

    /**
     * Busca una sección por su slug y retorna un array simple (sin exponer el modelo).
     */
    public function findArrayBySlug(string $slug): ?array
    {
        $seccion = CmsSeccion::where('slug', $slug)->first();
        return $seccion?->toArray();
    }

    /**
     * Crea o actualiza una sección por slug y retorna un array simple (sin exponer el modelo).
     */
    public function upsertBySlug(string $slug, array $data): array
    {
        $seccion = CmsSeccion::updateOrCreate(['slug' => $slug], $data);
        return $seccion->fresh()->toArray();
    }

    /**
     * Busca una sección por id y retorna un array simple (sin exponer el modelo).
     */
    public function findArrayById(int $id): ?array
    {
        $seccion = CmsSeccion::find($id);
        return $seccion?->toArray();
    }

    /**
     * Actualiza una sección por id y retorna un array simple (sin exponer el modelo).
     */
    public function updateById(int $id, array $data): ?array
    {
        $seccion = CmsSeccion::find($id);
        if (!$seccion) {
            return null;
        }

        $seccion->update($data);
        return $seccion->fresh()->toArray();
    }

    /**
     * Elimina una sección por id.
     */
    public function deleteById(int $id): bool
    {
        $seccion = CmsSeccion::find($id);
        return $seccion ? (bool) $seccion->delete() : false;
    }

    /**
     * Crea una nueva sección CMS
     */
    public function create(array $data): CmsSeccion
    {
        return CmsSeccion::create($data);
    }

    /**
     * Crea una nueva sección CMS y retorna un array simple.
     */
    public function createArray(array $data): array
    {
        return CmsSeccion::create($data)->fresh()->toArray();
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

