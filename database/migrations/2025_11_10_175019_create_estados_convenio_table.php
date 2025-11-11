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
        Schema::create('estados_convenio', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });

        DB::table('estados_convenio')->insert([
            ['nombre' => 'Vigente', 'descripcion' => 'El convenio está vigente.'],
            ['nombre' => 'Próximo a vencer', 'descripcion' => 'El convenio está próximo a vencer.'],
            ['nombre' => 'Finalizado', 'descripcion' => 'El convenio ha cumplido su término y ha finalizado.'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estados_convenio');
    }
};
