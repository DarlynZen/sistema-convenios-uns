<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function tipoConvenio(): BelongsTo
    {
        return $this->belongsTo(TipoConvenio::class, 'tipo_convenio_id');
    }

    public function ambito(): BelongsTo
    {
        return $this->belongsTo(Ambito::class, 'ambito_id');
    }

    public function estadoConvenio(): BelongsTo
    {
        return $this->belongsTo(EstadoConvenio::class, 'estado_convenio_id');
    }

    public function documento(): HasMany
    {
        return $this->hasMany(DocumentoConvenio::class);
    }

    public function convenioAnterior(): BelongsTo
    {
        return $this->belongsTo(Convenio::class, 'convenio_renovado_de');
    }

    public function convenioRenovado(): BelongsTo  //obs de HasMany
    {
        return $this->belongsTo(Convenio::class, 'id', 'convenio_renovado_de');
    }

    public function beneficiario(): BelongsToMany
    {
        return $this->belongsToMany(Beneficiario::class);
    }

}