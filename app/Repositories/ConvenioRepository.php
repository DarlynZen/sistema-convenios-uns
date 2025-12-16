<?php

namespace App\Repositories;

use App\Models\Ambito;
use App\Models\Convenio;
use App\Models\TipoConvenio;
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

    public function obtenerPorId($id)
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

    public function crear(array $data, ?array $beneficiarios = null)
    {
        $convenio = $this->modelo->create($data);

        if ($beneficiarios) {
            $convenio->beneficiario()->sync($beneficiarios);
        }
        return $convenio;
    }

    public function actualizar(int $id, array $data, ?array $beneficiarios = null)
    {
        $convenio = $this->modelo->findOrFail($id);

        $convenio->update($data);

        if ($beneficiarios) {
            $convenio->beneficiario()->sync($beneficiarios);
        }

        return $convenio;
    }

    public function eliminar(int $id): bool
    {
        $convenio = $this->modelo->findOrFail($id);
        return (bool) $convenio->delete();
    }

    public function obtenerConveniosActivos(): Builder
    {
        return $this->modelo->where('estado_convenio_id', EstadoConvenio::ACTIVO->value);
    }

    /*
    public function scopeRecientes($query, int $limit = 5)
    {
        return $query->with(['tipoConvenio', 'estadoConvenio'])
            ->latest()
            ->limit($limit);
    }

    public static function getDashboardStats(): array
    {
        return [
            'total_convenios' => self::count(),
            'convenios_activos' => self::activos()->count(),
            'tipos_convenio' => TipoConvenio::count(),
            'ambitos' => Ambito::count(),
            'recientes' => self::recientes(5)->get(),
        ];
    }*/
}
