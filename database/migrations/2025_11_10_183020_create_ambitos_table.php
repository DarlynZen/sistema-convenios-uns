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
        Schema::create('ambitos', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('nombre', 150);
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });

        DB::table('ambitos')->insert([
            ['nombre' => 'Nacional', 'descripcion' => 'Convenios que se aplican en todo el país.'],
            ['nombre' => 'Internacional', 'descripcion' => 'Convenios que involucran a múltiples países.'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ambitos');
    }
};
