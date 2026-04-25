<?php

namespace App\Services;

use App\Models\Convenio;
use App\Repositories\ConvenioRepository;
use Carbon\Carbon;

class ConvenioService
{
    public function __construct(
        private ConvenioRepository $repository
    ){}

    public function obtenerPorId(int $id): Convenio
    {
        return $this->repository->obtenerPorId($id);
    }

    public function obtenerConRelaciones(int $id): Convenio
    {
        return $this->repository->obtenerConRelaciones($id);
    }

    public function listarConRelaciones()
    {
        return $this->repository->listarConRelaciones();
    }

    public function crear(array $data): Convenio
    {
        [$data, $beneficiarios] = $this->validarDatosFormulario($data);

        return $this->repository->crear($data, $beneficiarios);
    }

    public function actualizar(int $id, array $data): Convenio
    {
        [$data, $beneficiarios] = $this->validarDatosFormulario($data);

        return $this->repository->actualizar($id, $data, $beneficiarios);
    }

    private function validarDatosFormulario(array $data): array
    {
        $beneficiarios = array_key_exists('beneficiarios', $data)
            ? (array) ($data['beneficiarios'] ?? [])
            : null;

        $data = $this->calcularFechaConDuracion($data);
        $data = $this->generarDetallesCoordinadores($data);
        $data['observaciones_prorroga'] = $data['observaciones_prorroga'] ?? ($data['observacion'] ?? null);

        unset(
            $data['beneficiarios'],
            $data['observacion'],
            $data['archivo_uno'],
            $data['archivo_dos']
        );

        return [$data, $beneficiarios];
    }

    private function calcularFechaConDuracion(array $data): array
    {
        $fechaInicio = $data['fecha_inicio'] ?? null;
        $duracionValor = isset($data['duracion_valor']) ? (int) $data['duracion_valor'] : null;
        $duracionUnidad = $data['duracion_unidad'] ?? null;

        if (!$fechaInicio || !$duracionValor || !$duracionUnidad) {
            return $data;
        }

        $fechaFin = Carbon::parse($fechaInicio);

        match ($duracionUnidad) {
            'dias' => $fechaFin->addDays($duracionValor),
            'semanas' => $fechaFin->addWeeks($duracionValor),
            'meses' => $fechaFin->addMonths($duracionValor),
            'anios' => $fechaFin->addYears($duracionValor),
            default => null,
        };

        $data['fecha_fin'] = $fechaFin->toDateString();
        return $data;
    }

    private function generarDetallesCoordinadores(array $data): array
    {
        $coordinadoresUns = collect($data['coordinador_uns'] ?? [])
            ->map(fn($value) => trim((string) $value))
            ->filter()
            ->values()
            ->all();

        $coordinadoresInstitucion = collect($data['coordinador_institucion'] ?? [])
            ->map(fn($value) => trim((string) $value))
            ->filter()
            ->values()
            ->all();

        $noSeMenciona = !empty($data['no_se_menciona']);

        if (!empty($coordinadoresUns) || !empty($coordinadoresInstitucion) || $noSeMenciona) {
            $data['detalles_coordinadores_json'] = [
                'coordinador_uns' => $coordinadoresUns,
                'coordinador_institucion' => $coordinadoresInstitucion,
                'no_se_menciona' => $noSeMenciona,
            ];
        }

        unset($data['coordinador_uns'], $data['coordinador_institucion'], $data['no_se_menciona']);

        return $data;
    }

    public function eliminar(int $id): bool
    {
        return $this->repository->eliminar($id);
    }

    public function obtenerCatalogos(): array
    {
        return $this->repository->obtenerCatalogos();
    }
}
