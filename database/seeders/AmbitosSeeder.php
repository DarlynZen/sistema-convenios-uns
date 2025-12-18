<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class AmbitosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ambitos')->insert([
            ['id' => 1, 'nombre' => 'Nacional', 'descripcion' => 'Convenios que se aplican a nivel nacional.'],
            ['id' => 2, 'nombre' => 'Internacional', 'descripcion' => 'Convenios que involucran a entidades de otros países.'],
        ]);
    }
}
