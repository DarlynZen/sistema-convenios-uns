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
            ['id' => 1, 'nombre' => 'Ingeniería', 'codigo_beneficiario' => 'ING', 'descripcion' => 'Facultad de Ingeniería', 'estado' => 1],
            ['id' => 2, 'nombre' => 'Educación y Humanidades', 'codigo_beneficiario' => 'EDU-HUM', 'descripcion' => 'Facultad de Educación y Humanidades', 'estado' => 1],
            ['id' => 3, 'nombre' => 'Ciencias ', 'codigo_beneficiario' => 'CIE', 'descripcion' => 'Escuela de Ciencias', 'estado' => 1],
        ]);
    }
}
