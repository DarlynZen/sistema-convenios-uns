<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposConvenioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipos_convenio')->insert([
            ['id' => 1, 'nombre' => 'Marco', 'descripcion' => 'Convenios marco para establecer relaciones generales.'],
            ['id' => 2, 'nombre' => 'Específico', 'descripcion' => 'Convenios para proyectos específicos o colaboraciones puntuales.'],
        ]);
    }
}
