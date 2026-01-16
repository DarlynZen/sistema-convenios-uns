<?php

namespace App\Repositories;

use App\Models\Ambito;
use App\Models\Convenio;
use App\Models\TipoConvenio;
use App\Models\Estado;
use App\Models\Beneficiario;
use App\Enums\EstadoConvenio;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

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

    public function actualizar(int $id, array $data, ?array $beneficiarios = null): Convenio
    {
        $convenio = $this->modelo->findOrFail($id);

        $convenio->update($data);

        if (!empty($beneficiarios)) {
            $convenio->beneficiario()->sync($beneficiarios);
        }

        return $convenio;
    }

    public function eliminar(int $id): bool
    {
        return (bool)$this->modelo->findOrFail($id)->delete();
    }

    public function obtenerConveniosActivos(): Builder
    {
        return $this->modelo->where('estado_convenio_id', EstadoConvenio::ACTIVO->value);
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

    public static function getDashboardStats(): array
    {
        return [
            'total_convenios' => Convenio::count(),
            'convenios_activos' => Convenio::where('estado_convenio_id', EstadoConvenio::ACTIVO->value)->count(),
            'tipos_convenio' => TipoConvenio::count(),
            'ambitos' => Ambito::count(),
            'recientes' => Convenio::with(['tipoConvenio', 'estadoConvenio'])
                ->latest()
                ->limit(5)
                ->get(),
        ];
    }
}
