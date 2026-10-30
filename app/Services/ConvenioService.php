<?php

namespace App\Services;

use App\Models\Convenio;
use App\Repositories\ConvenioRepository;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ConvenioService
{
    public function __construct(
        private ConvenioRepository $repository
    ) {
    }

    public function obtenerPorId(int $id): Convenio
    {
        return $this->repository->obtenerPorId($id);
    }

    public function obtenerConRelaciones(int $id): Convenio
    {
        return $this->repository->obtenerConRelaciones($id);
    }

    public function listarConRelaciones(): Collection
    {
        return $this->repository->listarConRelaciones();
    }

    public function crear(array $data): Convenio
    {
        [$data, $beneficiarios] = $this->prepararDatosFormulario($data);

        return $this->repository->crear($data, $beneficiarios);
    }

    public function actualizar(int $id, array $data): Convenio
    {
        [$data, $beneficiarios] = $this->prepararDatosFormulario($data);

        return $this->repository->actualizar($id, $data, $beneficiarios);
    }

    private function prepararDatosFormulario(array $data): array
    {
        $beneficiarios = array_key_exists('beneficiarios', $data)
            ? (array) ($data['beneficiarios'] ?? [])
            : null;

        $data = $this->calcularFechaConDuracion($data);
        $data = $this->generarDetallesCoordinadores($data);
        $data['observaciones_prorroga'] = filled($data['observaciones_prorroga'] ?? null)
            ? $data['observaciones_prorroga']
            : ($data['observacion'] ?? null);

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

        switch ($duracionUnidad) {
            case 'dias':
                $fechaFin->addDays($duracionValor);
                break;
            case 'semanas':
                $fechaFin->addWeeks($duracionValor);
                break;
            case 'meses':
                $fechaFin->addMonths($duracionValor);
                break;
            case 'anios':
                $fechaFin->addYears($duracionValor);
                break;
        }

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

    public function obtenerDatosMapa(): array
    {
        $datos = [];

        foreach ($this->repository->obtenerDatosMapa() as $nacionalidad) {
            $codigo = $this->normalizarCodigoPais((string) $nacionalidad);

            if ($codigo === null) {
                continue;
            }

            $datos[$codigo] = ($datos[$codigo] ?? 0) + 1;
        }

        ksort($datos);

        return array_map(
            fn (int $total) => ['agreements' => $total],
            $datos
        );
    }

    private function normalizarCodigoPais(string $nacionalidad): ?string
    {
        $valor = trim($nacionalidad);

        if ($valor === '') {
            return null;
        }

        $normalizado = Str::lower($valor);
        $normalizado = strtr($normalizado, [
            'á' => 'a', 'à' => 'a', 'ä' => 'a', 'â' => 'a',
            'é' => 'e', 'è' => 'e', 'ë' => 'e', 'ê' => 'e',
            'í' => 'i', 'ì' => 'i', 'ï' => 'i', 'î' => 'i',
            'ó' => 'o', 'ò' => 'o', 'ö' => 'o', 'ô' => 'o',
            'ú' => 'u', 'ù' => 'u', 'ü' => 'u', 'û' => 'u',
            'ñ' => 'n', 'ç' => 'c',
        ]);

        $normalizado = preg_replace('/[^a-z0-9\s]/', '', $normalizado);
        $normalizado = trim((string) $normalizado);

        $mapeo = [
            'argentina' => 'ARG',
            'bolivia' => 'BOL',
            'brasil' => 'BRA',
            'chile' => 'CHL',
            'colombia' => 'COL',
            'ecuador' => 'ECU',
            'guatemala' => 'GTM',
            'honduras' => 'HND',
            'mexico' => 'MEX',
            'nicaragua' => 'NIC',
            'panama' => 'PAN',
            'paraguay' => 'PRY',
            'peru' => 'PER',
            'uruguay' => 'URY',
            'venezuela' => 'VEN',
            'estados unidos' => 'USA',
            'united states' => 'USA',
            'united states of america' => 'USA',
            'usa' => 'USA',
            'canada' => 'CAN',
            'espana' => 'ESP',
            'francia' => 'FRA',
            'italia' => 'ITA',
            'alemania' => 'DEU',
            'japon' => 'JPN',
            'corea del sur' => 'KOR',
            'republica dominicana' => 'DOM',
            'dominican republic' => 'DOM',
        ];

        return $mapeo[$normalizado] ?? null;
    }
}
