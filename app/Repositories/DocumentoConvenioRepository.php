<?php

namespace App\Repositories;

use App\Models\DocumentoConvenio;
use App\Models\Convenio;
use Illuminate\Database\Eloquent\Collection;

class DocumentoConvenioRepository
{
    /**
     * Obtiene todos los documentos de un convenio ordenados por más recientes
     */
    public function getByConvenio(Convenio $convenio): Collection
    {
        return $convenio->documento()->latest()->get();
    }

    /**
     * Obtiene un documento con su convenio relacionado
     */
    public function findWithConvenio(int $id): DocumentoConvenio
    {
        return DocumentoConvenio::with('convenio')->findOrFail($id);
    }

    /**
     * Crea un nuevo documento
     */
    public function create(array $data): DocumentoConvenio
    {
        return DocumentoConvenio::create($data);
    }

    /**
     * Actualiza un documento existente
     */
    public function update(DocumentoConvenio $documento, array $data): DocumentoConvenio
    {
        $documento->update($data);
        return $documento->fresh();
    }

    /**
     * Elimina un documento
     */
    public function delete(DocumentoConvenio $documento): bool
    {
        return $documento->delete();
    }
}

