<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('beneficiarios', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('nombre', 255);
            $table->string('codigo_beneficiario', 255)->unique();
            $table->string('descripcion', 255)->nullable();
            $table->timestamps();
        });

        DB::table('beneficiarios')->insert([
            [
                'nombre' => 'Escuela Profesional de Ingeniería de Sistemas e Informática',
                'codigo_beneficiario' => 'ING-SIS-INF',
                'descripcion' => 'Miembros de la Escuela de Ingeniería de Sistemas e Informática',
            ],
            [
                'nombre' => 'Escuela Profesional de Medicina Humana',
                'codigo_beneficiario' => 'MED-HUM',
                'descripcion' => 'Miembros de la Escuela de Medicina Humana',
            ],
            [
                'nombre' => 'Escuela Profesional de Enfermería',
                'codigo_beneficiario' => 'ENF',
                'descripcion' => 'Miembros de la Escuela Profesional de Enfermería',
            ],
            [
                'nombre' => 'Escuela Profesional de Ingeniería Civil',
                'codigo_beneficiario' => 'ING-CIV',
                'descripcion' => 'Miembros de la Escuela Profesional de Ingeniería Civil',
            ],
            [
                'nombre' => 'Escuela Profesional de Ingeniería Industrial',
                'codigo_beneficiario' => 'ING-IND',
                'descripcion' => 'Miembros de la Escuela Profesional de Ingeniería Industrial',
            ],
            [
                'nombre' => 'Escuela Profesional de Contabilidad',
                'codigo_beneficiario' => 'CONTAB',
                'descripcion' => 'Miembros de la Escuela Profesional de Contabilidad',
            ],
            [
                'nombre' => 'Escuela Profesional de Administración',
                'codigo_beneficiario' => 'ADM',
                'descripcion' => 'Miembros de la Escuela Profesional de Administración',
            ],
            [
                'nombre' => 'Escuela Profesional de Derecho',
                'codigo_beneficiario' => 'DER',
                'descripcion' => 'Miembros de la Escuela Profesional de Derecho',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiarios');
    }
};
