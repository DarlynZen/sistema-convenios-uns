<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('convenios', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->foreignId('tipo_convenio_id')->constrained('tipos_convenio');
            $table->foreignId('ambito_id')->constrained('ambitos');
            $table->foreignId('estado_convenio_id')->constrained('estados_convenio');
            $table->text('resolucion', 255);
            $table->string('titulo', 255);
            $table->text('objetivo_personalizado')->nullable();
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->integer('duracion_valor');
            $table->string('duracion_unidad', 50);
            $table->integer('plazo_prorroga_valor');
            $table->enum('plazo_prorroga_unidad', ['dias','semanas','meses']);
            $table->text('observaciones_prorroga')->nullable();
        
            //Datos de la entidad asociada
            $table->string('entidad_nombre', 255);
            $table->string('entidad_logo', 255)->nullable();
            $table->string('entidad_tipo', 255);
            $table->string('nacionalidad', 255);
            $table->json('detalles_coordinadores_json')->nullable();

            $table->foreignId('convenio_renovado_de')->nullable()->constrained('convenios');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('convenios');
    }
};
