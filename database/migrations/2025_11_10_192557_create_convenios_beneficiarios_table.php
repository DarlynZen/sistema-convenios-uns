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
        Schema::create('convenios_beneficiarios', function (Blueprint $table) {
            $table->foreignId('convenio_id')->constrained('convenios')->onDelete('cascade');
            $table->foreignId('beneficiario_id')->constrained('beneficiarios')->onDelete('restrict'); //ver si no hay errores cambiar el restrict
            $table->primary(['convenio_id', 'beneficiario_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('convenios_beneficiarios');
    }
};
