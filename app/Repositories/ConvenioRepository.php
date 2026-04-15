<?php

namespace App\Repositories;

use App\Models\Ambito;
use App\Models\Convenio;
use App\Models\TipoConvenio;
use App\Models\Estado;
use App\Models\Beneficiario;
use App\Enums\EstadoConvenio;

class ConvenioRepository
{

    protected Convenio $modelo;

    public function __construct(Convenio $convenio)
    {
        $this->modelo = $convenio;
    }

    public function obtenerPorId(int $id): Convenio
    {
        return $this->modelo->findOrFail($id);
    }

    public function obtenerTodoConRelaciones()
    {
        return $this->modelo->with([
            'tipoConvenio',
            'ambito',
            'estadoConvenio',
            'beneficiario',
            'documento',
            'convenioAnterior'
        ])->get();
    }

    public function obtenerIdConRelaciones(int $id)
    {
        return $this->modelo->with([
            'tipoConvenio',
            'ambito',
            'estadoConvenio',
            'beneficiario',
            'documento',
            'convenioAnterior'
        ])->find($id);
    }

    public function crear(array $data): Convenio
    {
        return $this->modelo->create($data);
    }

    public function actualizar(int $id, array $data): Convenio
    {
        $convenio = $this->modelo->findOrFail($id);
        $convenio->update($data);
        return $convenio->fresh();
    }

    public function eliminar(int $id): bool
    {
        return (bool)$this->modelo->findOrFail($id)->delete();
    }

    public function obtenerCatalogos(): array
    {
        return [
            'tiposConvenio' => TipoConvenio::all(),
            'ambitos' => Ambito::all(),
            'estadosConvenio' => Estado::all(),
            'beneficiarios' => Beneficiario::all(),
        ];
    }

    public function scopeRecientes($query, int $limit = 5)
    {
        return $query->with(['tipoConvenio', 'estadoConvenio'])
            ->latest()
            ->limit($limit);
    }
}
