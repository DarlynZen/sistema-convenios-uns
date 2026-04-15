<?php

namespace App\Repositories;

use App\Models\CmsSeccion;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CmsSeccionRepository
{
    public function getAll(): Collection
    {
        return CmsSeccion::latest()->get();
    }

    public function getAllArray(): array
    {
        return CmsSeccion::latest()->get()->toArray();
    }

    public function paginateArray(int $perPage = 15): array
    {
        /** @var LengthAwarePaginator $paginator */
        $paginator = CmsSeccion::latest()->paginate($perPage);
        return $paginator->toArray();
    }

    public function findBySlug(string $slug): ?CmsSeccion
    {
        return CmsSeccion::where('slug', $slug)->first();
    }

    public function findArrayBySlug(string $slug): ?array
    {
        $seccion = CmsSeccion::where('slug', $slug)->first();
        return $seccion?->toArray();
    }

    public function upsertBySlug(string $slug, array $data): array
    {
        $seccion = CmsSeccion::updateOrCreate(['slug' => $slug], $data);
        return $seccion->fresh()->toArray();
    }

    public function findArrayById(int $id): ?array
    {
        $seccion = CmsSeccion::find($id);
        return $seccion?->toArray();
    }

    public function updateById(int $id, array $data): ?array
    {
        $seccion = CmsSeccion::find($id);
        if (!$seccion) {
            return null;
        }

        $seccion->update($data);
        return $seccion->fresh()->toArray();
    }

    public function deleteById(int $id): bool
    {
        $seccion = CmsSeccion::find($id);
        return $seccion ? (bool) $seccion->delete() : false;
    }

    public function create(array $data): CmsSeccion
    {
        return CmsSeccion::create($data);
    }


    public function createArray(array $data): array
    {
        return CmsSeccion::create($data)->fresh()->toArray();
    }

    public function update(CmsSeccion $seccion, array $data): CmsSeccion
    {
        $seccion->update($data);
        return $seccion->fresh();
    }

    public function delete(CmsSeccion $seccion): bool
    {
        return $seccion->delete();
    }
}

