<?php

namespace App\Repositories;

use App\Models\Convenio;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ConvenioRepository
{
    /**
     * Obtiene todos los convenios con sus relaciones principales paginados
     */
    public function getAllWithRelations(): LengthAwarePaginator
    {
        return Convenio::with(['tipoConvenio', 'ambito', 'estadoConvenio'])
            ->latest()
            ->paginate(15);
    }

    /**
     * Obtiene un convenio con todas sus relaciones cargadas
     */
    public function findWithAllRelations(int $id): Convenio
    {
        return Convenio::with([
            'tipoConvenio',
            'ambito',
            'estadoConvenio',
            'beneficiario',
            'documento',
            'convenioAnterior'
        ])->findOrFail($id);
    }

    /**
     * Carga todas las relaciones en un convenio existente
     */
    public function loadAllRelations(Convenio $convenio): Convenio
    {
        return $convenio->load([
            'tipoConvenio',
            'ambito',
            'estadoConvenio',
            'beneficiario',
            'documento',
            'convenioAnterior'
        ]);
    }

    /**
     * Crea un convenio con sus beneficiarios asociados
     */
    public function createWithBeneficiarios(array $data, ?array $beneficiarios = null): Convenio
    {
        $convenio = Convenio::create($data);
        
        if ($beneficiarios) {
            $convenio->beneficiario()->sync($beneficiarios);
        }
        
        return $convenio;
    }

    /**
     * Actualiza un convenio y sus beneficiarios asociados
     */
    public function updateWithBeneficiarios(
        Convenio $convenio, 
        array $data, 
        ?array $beneficiarios = null
    ): Convenio {
        $convenio->update($data);
        
        if ($beneficiarios !== null) {
            $convenio->beneficiario()->sync($beneficiarios);
        } else {
            $convenio->beneficiario()->detach();
        }
        
        return $convenio->fresh();
    }

    /**
     * Elimina un convenio y limpia sus relaciones many-to-many
     */
    public function deleteWithRelations(Convenio $convenio): bool
    {
        $convenio->beneficiario()->detach();
        return $convenio->delete();
    }

    /**
     * Obtiene un convenio con la relación de beneficiarios cargada
     */
    public function findWithBeneficiarios(int $id): Convenio
    {
        return Convenio::with('beneficiario')->findOrFail($id);
    }

    /**
     * Obtiene los convenios más recientes
     */
    public function getRecent(int $limit = 5)
    {
        return Convenio::recientes($limit)->get();
    }
}

