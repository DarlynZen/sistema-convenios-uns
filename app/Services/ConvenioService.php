<?php

namespace App\Services;

use App\Enums\EstadoConvenio;
use App\Repositories\ConvenioRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ConvenioService
{
    public function __construct(
        private ConvenioRepository $repository
    ) {}

    public function obtenerPorId($id)
    {
        return $this->repository->obtenerPorId($id);
    }

    public function obtenerTodoConRelaciones(){
        return $this->repository->obtenerTodoConRelaciones();
    }

    public function crear(array $data, ?array $beneficiarios = null)
    {
        return $this->repository->crear($data, $beneficiarios);
    }

    public function actualizar(int $id, array $data, ?array $beneficiarios = null)
    {
        return $this->repository->actualizar($id, $data, $beneficiarios);
    }

    public function eliminar(int $id): bool
    {
        return $this->repository->eliminar($id);
    }

    public function obtenerConveniosActivos(): Builder
    {
        return $this->repository->obtenerConveniosActivos();
    }

    public function obtenerListado(): array
    {
        return [
            'tiposConvenio' => TipoConvenio::all(),
            'ambitos' => Ambito::all(),
            'estadosConvenio' => Estado::all(),
            'beneficiarios' => Beneficiario::all(),
        ];
    }

    public function getEditFormData(Convenio $convenio): array
    {
        $convenio->load('beneficiario');

        return [
            'convenio' => $convenio,
            'tiposConvenio' => TipoConvenio::all(),
            'ambitos' => Ambito::all(),
            'estadosConvenio' => Estado::all(),
            'beneficiarios' => Beneficiario::all(),
        ];
    }
}

