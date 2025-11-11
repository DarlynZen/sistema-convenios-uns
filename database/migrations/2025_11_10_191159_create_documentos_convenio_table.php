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
        Schema::create('documentos_convenio', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->foreignId('convenio_id')->constrained('convenios');
            $table->string('tipo_documento', 100);
            $table->string('nombre_archivo', 255);
            $table->string('ruta_archivo', 500);
            $table->integer('version')->default(1);
            $table->boolean('activo')->default(true);
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos_convenio');
    }
};
