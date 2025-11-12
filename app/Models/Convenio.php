<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Convenio extends Model
{
    protected $table = 'convenios';

    protected $fillable = [
        'tipo_convenio_id',
        'ambito_id',
        'estado_convenio_id',
        'resolucion',
        'titulo',
        'objetivo_personalizado',
        'fecha_inicio',
        'fecha_fin',
        'plazo_prorroga_valor',
        'plazo_prorroga_unidad',
        'entidad_nombre',
        'entidad_logo',
        'entidad_tipo',
        'nacionalidad',
        'detalles_coordinadores_json',
        'convenio_renovado_de',
    ];

    protected $casts = [
        'tipo_convenio_id' => 'integer',
        'ambito_id' => 'integer',
        'estado_convenio_id' => 'integer',
        'resolucion' => 'string',
        'titulo' => 'string',
        'objetivo_personalizado' => 'string',
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'plazo_prorroga_valor' => 'integer',  //enum ver docs
        'plazo_prorroga_unidad' => 'string',
        'entidad_nombre' => 'string',
        'entidad_logo' => 'string',
        'entidad_tipo' => 'string',
        'nacionalidad' => 'string',
        'detalles_coordinadores_json' => 'array',
        'convenio_renovado_de' => 'integer',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
