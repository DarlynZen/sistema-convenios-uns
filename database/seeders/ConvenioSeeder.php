<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Convenio;

class ConvenioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*Convenio::factory(3)->create();*/

        DB::table('convenios')->insert([
            [
                'tipo_convenio_id'      => 1,
                'ambito_id'             => 1,
                'estado_convenio_id'    => 1,

                'resolucion'            => 'Resolución Rectoral N° 123-2024-UNS',
                'titulo'                => 'Convenio Marco con la Escuela de Ingeniería de Sistemas e Informática',
                'objetivo_personalizado'=> 'Fomentar actividades académicas, investigación y prácticas profesionales.',

                'fecha_inicio'          => '2024-01-01',
                'fecha_fin'             => '2027-01-01',

                'duracion_valor'        => 3,
                'duracion_unidad'      => 'años',

                'plazo_prorroga_valor'  => 12,
                'plazo_prorroga_unidad' => 'meses',
                'observaciones_prorroga' => 'La prórroga se otorgará si se han cumplido al menos el 90% de las actividades programadas.',

                // Datos de entidad asociada
                'entidad_nombre'        => 'Universidad de Lima',
                'entidad_logo'          => 'convenios/logos/sistemas.png',  // ruta en storage/public o public/
                'entidad_tipo'          => 'Escuela Profesional',
                'nacionalidad'          => 'Perú',

                'detalles_coordinadores_json' => json_encode([
                    'coordinador_academico' => 'Ing. Carlos Ramírez',
                    'coordinador_entidad'   => 'MSc. Ana Torres'
                ]),

                'convenio_renovado_de'  => null, // O colocar el ID de un convenio anterior

                'created_at'            => now(),
                'updated_at'            => now(),
            ],

            [
                'tipo_convenio_id'      => 2,
                'ambito_id'             => 2,
                'estado_convenio_id'    => 1,

                'resolucion'            => 'Resolución Rectoral N° 245-2024-UNS',
                'titulo'                => 'Convenio Específico con Medicina Humana',
                'objetivo_personalizado'=> null,

                'fecha_inicio'          => '2023-05-10',
                'fecha_fin'             => '2026-05-10',

                'duracion_valor'        => 3,
                'duracion_unidad'       => 'años',

                'plazo_prorroga_valor'  => 6,
                'plazo_prorroga_unidad' => 'meses',
                'observaciones_prorroga' => 'La prórroga se otorgará si se han cumplido al menos el 80% de las actividades programadas.',

                'entidad_nombre'        => 'Universidad Nacional Mayor de San Marcos',
                'entidad_logo'          => 'convenios/logos/medicina.png',
                'entidad_tipo'          => 'Universidad Pública',
                'nacionalidad'          => 'Perú',

                'detalles_coordinadores_json' => json_encode([
                    'coordinador_academico' => 'Dr. Luis Paredes',
                    'coordinador_entidad'   => 'Dra. María Gutiérrez'
                ]),

                'convenio_renovado_de' => null,

                'created_at'           => now(),
                'updated_at'           => now(),
            ],
        ]);
    }
}
