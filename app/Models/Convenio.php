<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $tipo_convenio_id
 * @property int $ambito_id
 * @property int $estado_convenio_id
 * @property string $resolucion
 * @property string $titulo
 * @property string|null $objetivo_personalizado
 * @property string|null $observaciones_prorroga
 * @property \Illuminate\Support\Carbon $fecha_inicio
 * @property \Illuminate\Support\Carbon $fecha_fin
 * @property int $plazo_prorroga_valor
 * @property string $plazo_prorroga_unidad
 * @property string $entidad_nombre
 * @property string $entidad_logo
 * @property string $entidad_tipo
 * @property string $nacionalidad
 * @property array<array-key, mixed>|null $detalles_coordinadores_json
 * @property int|null $convenio_renovado_de
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Ambito $ambito
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Beneficiario> $beneficiario
 * @property-read int|null $beneficiario_count
 * @property-read Convenio|null $convenioAnterior
 * @property-read Convenio|null $convenioRenovado
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DocumentoConvenio> $documento
 * @property-read int|null $documento_count
 * @property-read \App\Models\Estado $estadoConvenio
 * @property-read mixed $duracion
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Observacion> $observaciones
 * @property-read int|null $observaciones_count
 * @property-read \App\Models\TipoConvenio $tipoConvenio
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Convenio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Convenio newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Convenio query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Convenio whereAmbitoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Convenio whereConvenioRenovadoDe($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Convenio whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Convenio whereDetallesCoordinadoresJson($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Convenio whereEntidadLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Convenio whereEntidadNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Convenio whereEntidadTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Convenio whereEstadoConvenioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Convenio whereFechaFin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Convenio whereFechaInicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Convenio whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Convenio whereNacionalidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Convenio whereObjetivoPersonalizado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Convenio wherePlazoProrrogaUnidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Convenio wherePlazoProrrogaValor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Convenio whereResolucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Convenio whereTipoConvenioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Convenio whereTitulo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Convenio whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Convenio extends Model
{
    use HasFactory;
    protected $table = 'convenios';

    protected $fillable = [
        'tipo_convenio_id',
        'ambito_id',
        'estado_convenio_id',
        'resolucion',
        'titulo',
        'objetivo_personalizado',
        'observaciones_prorroga',
        'fecha_inicio',
        'fecha_fin',
        'duracion_valor',
        'duracion_unidad',
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
        'observaciones_prorroga' => 'string',
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
        return $this->belongsTo(Estado::class, 'estado_convenio_id');
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
        return $this->belongsToMany(Beneficiario::class, 'convenios_beneficiarios', 'convenio_id', 'beneficiario_id');
    }

    public function observaciones(): HasMany
    {
        return $this->hasMany(Observacion::class);
    }

    public function getDuracionAttribute()
    {
        return $this->fecha_inicio
            ->locale('es')
            ->diffForHumans($this->fecha_fin, true);
    }
}
