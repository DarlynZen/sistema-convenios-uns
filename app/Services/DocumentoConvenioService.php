<?php

namespace App\Services;

use App\Models\Convenio;
use App\Models\DocumentoConvenio;
use App\Repositories\DocumentoConvenioRepository;
use Illuminate\Http\UploadedFile;

class DocumentoConvenioService
{
    public function __construct(
        private DocumentoConvenioRepository $repository,
        private FileService $fileService
    ) {}

    /**
     * Crea un nuevo documento asociado a un convenio
     */
    public function create(Convenio $convenio, array $data): DocumentoConvenio
    {
        // Extraer el archivo del array de datos
        $file = $data['documento'] ?? null;
        unset($data['documento']);

        // Almacenar el archivo si existe
        if ($file instanceof UploadedFile) {
            $data['ruta_documento'] = $this->fileService->store($file, 'documentos/convenios');
        }

        // Establecer valores por defecto
        $data['convenio_id'] = $convenio->id;
        $data['version'] = $data['version'] ?? 1;
        $data['activo'] = $data['activo'] ?? true;

        return $this->repository->create($data);
    }

    /**
     * Actualiza un documento existente
     */
    public function update(DocumentoConvenio $documento, array $data): DocumentoConvenio
    {
        // Extraer el archivo del array de datos si existe
        $file = $data['documento'] ?? null;
        unset($data['documento']);

        // Si se envía un nuevo archivo, eliminar el anterior y almacenar el nuevo
        if ($file instanceof UploadedFile) {
            // Eliminar archivo anterior si existe
            if ($documento->ruta_documento) {
                $this->fileService->delete($documento->ruta_documento);
            }

            // Almacenar el nuevo archivo
            $data['ruta_documento'] = $this->fileService->store($file, 'documentos/convenios');
        }

        return $this->repository->update($documento, $data);
    }

    /**
     * Elimina un documento y su archivo asociado
     */
    public function delete(DocumentoConvenio $documento): void
    {
        // Eliminar el archivo físico si existe
        if ($documento->ruta_documento) {
            $this->fileService->delete($documento->ruta_documento);
        }

        // Eliminar el registro de la base de datos
        $this->repository->delete($documento);
    }

    /**
     * Descarga un documento
     */
    public function download(DocumentoConvenio $documento)
    {
        return $this->fileService->download(
            $documento->ruta_documento,
            $documento->nombre_documento
        );
    }
}

