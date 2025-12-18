<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class BeneficiariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('beneficiarios')->insert([
            ['id' => 1, 'nombre' => 'Facultad de Ingeniería', 'codigo_beneficiario' => 'ING', 'descripcion' => 'Facultad de Ingeniería'],
            ['id' => 2, 'nombre' => 'Facultad de Educación y Humanidades', 'codigo_beneficiario' => 'EDU-HUM', 'descripcion' => 'Facultad de Educación y Humanidades'],
            ['id' => 3, 'nombre' => 'Facultad de Ciencias ', 'codigo_beneficiario' => 'CIE', 'descripcion' => 'Escuela de Ciencias'],
        ]);
    }
}
