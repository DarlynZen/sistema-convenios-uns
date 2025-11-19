<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FileService
{
    /**
     * Almacena un archivo en el disco público
     */
    public function store(UploadedFile $file, string $directory = 'documentos'): string
    {
        return $file->store($directory, 'public');
    }

    /**
     * Elimina un archivo del disco público si existe
     */
    public function delete(string $path): bool
    {
        if ($this->exists($path)) {
            return Storage::disk('public')->delete($path);
        }
        return false;
    }

    /**
     * Verifica si un archivo existe en el disco público
     */
    public function exists(string $path): bool
    {
        return Storage::disk('public')->exists($path);
    }

    /**
     * Descarga un archivo del disco público
     */
    public function download(string $path, string $filename): BinaryFileResponse
    {
        if (!$this->exists($path)) {
            abort(404, 'Archivo no encontrado.');
        }

        return response()->download(
            Storage::disk('public')->path($path),
            $filename
        );
    }

    /**
     * Obtiene la ruta completa del archivo
     */
    public function path(string $path): string
    {
        return Storage::disk('public')->path($path);
    }
}

