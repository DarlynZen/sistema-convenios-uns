<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class EstadosConvenioSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('estados_convenio')->insert([
            ['id' => 1, 'nombre' => 'Activo'],
            ['id' => 2, 'nombre' => 'Vencido'],
            ['id' => 3, 'nombre' => 'En Revisión'],
        ]);
    }
}
