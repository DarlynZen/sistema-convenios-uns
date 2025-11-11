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
        Schema::create('cms_seccion', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('slug', 100);
            $table->string('titulo', 255);
            $table->text('descripcion')->nullable();
            $table->json('contenido_json')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cms_seccion');
    }
};
