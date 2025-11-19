<?php

namespace App\Services;

use App\Models\Convenio;
use App\Models\TipoConvenio;
use App\Models\Ambito;
use App\Models\EstadoConvenio;
use App\Models\Beneficiario;
use App\Repositories\ConvenioRepository;
use Illuminate\Support\Facades\DB;

class ConvenioService
{
    public function __construct(
        private ConvenioRepository $repository
    ) {}

    /**
     * Crea un convenio con sus beneficiarios en una transacción
     */
    public function create(array $data): Convenio
    {
        return DB::transaction(function () use ($data) {
            $beneficiarios = $data['beneficiarios'] ?? null;
            unset($data['beneficiarios']);
            
            return $this->repository->createWithBeneficiarios($data, $beneficiarios);
        });
    }

    /**
     * Actualiza un convenio con sus beneficiarios en una transacción
     */
    public function update(Convenio $convenio, array $data): Convenio
    {
        return DB::transaction(function () use ($convenio, $data) {
            $beneficiarios = $data['beneficiarios'] ?? null;
            unset($data['beneficiarios']);
            
            return $this->repository->updateWithBeneficiarios($convenio, $data, $beneficiarios);
        });
    }

    /**
     * Elimina un convenio y limpia sus relaciones
     */
    public function delete(Convenio $convenio): void
    {
        $this->repository->deleteWithRelations($convenio);
    }

    /**
     * Obtiene los datos necesarios para el formulario de creación
     */
    public function getCreateFormData(): array
    {
        return [
            'tiposConvenio' => TipoConvenio::all(),
            'ambitos' => Ambito::all(),
            'estadosConvenio' => EstadoConvenio::all(),
            'beneficiarios' => Beneficiario::all(),
        ];
    }

    /**
     * Obtiene los datos necesarios para el formulario de edición
     */
    public function getEditFormData(Convenio $convenio): array
    {
        $convenio->load('beneficiario');
        
        return [
            'convenio' => $convenio,
            'tiposConvenio' => TipoConvenio::all(),
            'ambitos' => Ambito::all(),
            'estadosConvenio' => EstadoConvenio::all(),
            'beneficiarios' => Beneficiario::all(),
        ];
    }
}

