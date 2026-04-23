<?php

namespace App\Repositories;

use App\Enums\EstadoConvenio;
use App\Models\Ambito;
use App\Models\Beneficiario;
use App\Models\Convenio;
use App\Models\Estado;
use App\Models\TipoConvenio;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

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

    public function obtenerConRelaciones(int $id): Convenio
    {
        return $this->queryConRelaciones()->findOrFail($id);
    }

    public function listarConRelaciones(): Collection
    {
        return $this->queryConRelaciones()->get();
    }

    public function crear(array $data, ?array $beneficiarios = null): Convenio
    {
        return DB::transaction(function () use ($data, $beneficiarios) {
            $convenio = $this->modelo->create($data);

            if ($beneficiarios !== null) {
                $convenio->beneficiario()->sync($beneficiarios);
                $convenio = $convenio->fresh();
            }

            return $convenio;
        });
    }

    public function actualizar(int $id, array $data, ?array $beneficiarios = null): Convenio
    {
        return DB::transaction(function () use ($id, $data, $beneficiarios) {
            $convenio = $this->modelo->findOrFail($id);
            $convenio->update($data);

            if ($beneficiarios !== null) {
                $convenio->beneficiario()->sync($beneficiarios);
            }

            return $convenio->fresh();
        });
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

    public function contarTotal(): int { 
        return $this->modelo->count();
    }

    public function contarActivos(): int {
        return $this->modelo->where('estado_convenio_id', EstadoConvenio::ACTIVO->value)->count(); 
    }

    public function contarTipos(): int { 
        return TipoConvenio::count(); 
    }

    public function contarAmbitos(): int { 
        return Ambito::count(); 
    }

    public function contarRecientes($query, int $limit = 5)
    {
        return $query->with(['tipoConvenio', 'estadoConvenio'])
            ->latest()
            ->limit($limit);
    }

    public function recientes(int $limit = 5)
    {
        return $this->modelo->with(['tipoConvenio', 'estadoConvenio'])
            ->latest()
            ->limit($limit)
            ->get();
    }

    private function queryConRelaciones(): Builder
    {
        return $this->modelo->newQuery()->with([
            'tipoConvenio',
            'ambito',
            'estadoConvenio',
            'beneficiario',
            'documento',
            'convenioAnterior',
        ]);
    }
}
