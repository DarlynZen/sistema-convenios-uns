<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BeneficiarioConvenioSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('convenios_beneficiarios')->insert([
            ['convenio_id' => 1, 'beneficiario_id' => 1],
            ['convenio_id' => 1, 'beneficiario_id' => 2],
            ['convenio_id' => 2, 'beneficiario_id' => 3],
        ]);
    }
}
