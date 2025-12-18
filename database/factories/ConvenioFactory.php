<?php

namespace Database\Factories;

use App\Models\Ambito;
use App\Models\Convenio;
use App\Models\Estado;
use App\Models\TipoConvenio;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ConvenioFactory extends Factory
{
    protected $model = Convenio::class;

    public function definition(): array
    {
        return [
            'resolucion' => $this->faker->word(),
            'titulo' => $this->faker->word(),
            'objetivo_personalizado' => $this->faker->word(),
            'fecha_inicio' => now(),
            'fecha_fin' => now(),
            'plazo_prorroga_valor' => $this->faker->randomNumber(),
            'plazo_prorroga_unidad' => $this->faker->word(),
            'entidad_nombre' => $this->faker->word(),
            'entidad_logo' => $this->faker->word(),
            'entidad_tipo' => $this->faker->word(),
            'nacionalidad' => $this->faker->word(),
            'detalles_coordinadores_json' => $this->faker->word(),

            'tipo_convenio_id' => TipoConvenio::inRandomOrder()->value('id'),
            'ambito_id' => Ambito::inRandomOrder()->value('id'),
            'estado_convenio_id' => Estado::inRandomOrder()->value('id'),

            // Opcional
            'convenio_renovado_de' => Convenio::inRandomOrder()->value('id'),
        ];
    }
}
