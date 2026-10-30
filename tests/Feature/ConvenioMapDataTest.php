<?php

use App\Enums\EstadoConvenio;
use App\Models\Ambito;
use App\Models\Convenio;
use App\Models\Estado;
use App\Models\TipoConvenio;

test('the map data endpoint aggregates active agreements by country code', function () {
    $tipo = TipoConvenio::query()->firstOrCreate(['id' => 1], ['nombre' => 'Tipo de prueba']);
    $ambito = Ambito::query()->firstOrCreate(['id' => 1], ['nombre' => 'Ámbito de prueba']);
    $estadoActivo = Estado::query()->firstOrCreate(['id' => EstadoConvenio::ACTIVO->value], ['nombre' => 'Activo']);
    $estadoVencido = Estado::query()->firstOrCreate(['id' => EstadoConvenio::VENCIDO->value], ['nombre' => 'Vencido']);

    Convenio::query()->create([
        'tipo_convenio_id' => $tipo->id,
        'ambito_id' => $ambito->id,
        'estado_convenio_id' => $estadoActivo->id,
        'resolucion' => 'R-001',
        'titulo' => 'Convenio 1',
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => '2027-01-01',
        'duracion_valor' => 3,
        'duracion_unidad' => 'anios',
        'plazo_prorroga_valor' => 12,
        'plazo_prorroga_unidad' => 'meses',
        'entidad_nombre' => 'Entidad 1',
        'entidad_logo' => 'logo.png',
        'entidad_tipo' => 'Universidad',
        'nacionalidad' => 'Perú',
        'detalles_coordinadores_json' => [],
    ]);

    Convenio::query()->create([
        'tipo_convenio_id' => $tipo->id,
        'ambito_id' => $ambito->id,
        'estado_convenio_id' => $estadoActivo->id,
        'resolucion' => 'R-002',
        'titulo' => 'Convenio 2',
        'fecha_inicio' => '2024-01-02',
        'fecha_fin' => '2027-01-02',
        'duracion_valor' => 3,
        'duracion_unidad' => 'anios',
        'plazo_prorroga_valor' => 12,
        'plazo_prorroga_unidad' => 'meses',
        'entidad_nombre' => 'Entidad 2',
        'entidad_logo' => 'logo.png',
        'entidad_tipo' => 'Universidad',
        'nacionalidad' => 'Perú',
        'detalles_coordinadores_json' => [],
    ]);

    Convenio::query()->create([
        'tipo_convenio_id' => $tipo->id,
        'ambito_id' => $ambito->id,
        'estado_convenio_id' => $estadoVencido->id,
        'resolucion' => 'R-003',
        'titulo' => 'Convenio 3',
        'fecha_inicio' => '2022-01-01',
        'fecha_fin' => '2023-01-01',
        'duracion_valor' => 1,
        'duracion_unidad' => 'anios',
        'plazo_prorroga_valor' => 12,
        'plazo_prorroga_unidad' => 'meses',
        'entidad_nombre' => 'Entidad 3',
        'entidad_logo' => 'logo.png',
        'entidad_tipo' => 'Universidad',
        'nacionalidad' => 'Perú',
        'detalles_coordinadores_json' => [],
    ]);

    Convenio::query()->create([
        'tipo_convenio_id' => $tipo->id,
        'ambito_id' => $ambito->id,
        'estado_convenio_id' => $estadoActivo->id,
        'resolucion' => 'R-004',
        'titulo' => 'Convenio 4',
        'fecha_inicio' => '2024-02-01',
        'fecha_fin' => '2027-02-01',
        'duracion_valor' => 3,
        'duracion_unidad' => 'anios',
        'plazo_prorroga_valor' => 12,
        'plazo_prorroga_unidad' => 'meses',
        'entidad_nombre' => 'Entidad 4',
        'entidad_logo' => 'logo.png',
        'entidad_tipo' => 'Universidad',
        'nacionalidad' => 'Brasil',
        'detalles_coordinadores_json' => [],
    ]);

    $response = $this->get('/admin/convenios/map-data');

    $response
        ->assertOk()
        ->assertJsonPath('PER.agreements', 2)
        ->assertJsonPath('BRA.agreements', 1);
});
