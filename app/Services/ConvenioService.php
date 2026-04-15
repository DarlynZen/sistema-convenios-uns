<?php

namespace App\Services;

use App\Models\Convenio;
use App\Repositories\ConvenioRepository;
use Illuminate\Support\Facades\DB;

class ConvenioService
{
    public function __construct(
        private ConvenioRepository $repository
    ){}

    public function obtenerPorId(int $id): Convenio
    {
        return $this->repository->obtenerPorId($id);
    }

    public function listarConvenios()
    {
        return $this->repository->obtenerTodoConRelaciones();
    }

    /**
     * @throws \Throwable
     */
    public function crear(array $data, ?array $beneficiarios = null): Convenio
    {
        return DB::transaction(function () use ($data, $beneficiarios) {

            $convenio = $this->repository->crear($data);

            if ($beneficiarios !== null) {
                $convenio->beneficiario()->sync($beneficiarios);
            }
            return $convenio;
        });
    }

    public function actualizar(int $id, array $data, ?array $beneficiarios = null): Convenio
    {
        return DB::transaction(function () use ($id, $data, $beneficiarios) {
            $convenio = $this->repository->actualizar($id, $data);

            if ($beneficiarios !== null) {
                $convenio->beneficiario()->sync($beneficiarios);
                $convenio = $convenio->fresh();
            }

            return $convenio;
        });
    }

    public function eliminar(int $id): bool
    {
        return $this->repository->eliminar($id);
    }

    public function obtenerCatalogos(): array
    {
        return $this->repository->obtenerCatalogos();
    }

    public function obtenerDatosIndex(): array
    {
        return array_merge(
            ['convenios' => $this->listarConvenios()],
            $this->obtenerCatalogos()
        );
    }

    public function getEditFormData(Convenio $convenio): array
    {
        return $this->getEditFormDataById($convenio->id);
    }

    public function getEditFormDataById(int $id): array
    {
        $convenio = $this->obtenerPorId($id);
        $convenio->load('beneficiario');

        return array_merge([
            'convenio' => $convenio,
        ], $this->obtenerCatalogos());
    }

    public function getShowViewData(int $id): array
    {
        $convenio = $this->obtenerPorId($id);
        $convenio->load([
            'tipoConvenio',
            'ambito',
            'estadoConvenio',
            'beneficiario',
            'documento',
            'convenioAnterior',
        ]);

        return compact('convenio');
    }
}

 