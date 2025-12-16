<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $convenio_id
 * @property string $descripcion
 * @property \Illuminate\Support\Carbon $fecha_creacion
 * @property \Illuminate\Support\Carbon $fecha_actualizacion
 * @property int $version
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Convenio $convenio
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Observacion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Observacion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Observacion query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Observacion whereConvenioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Observacion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Observacion whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Observacion whereFechaActualizacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Observacion whereFechaCreacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Observacion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Observacion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Observacion whereVersion($value)
 * @mixin \Eloquent
 */
class Observacion extends Model
{
    protected $table = 'observaciones';

    protected $fillable = [
        'convenio_id',
        'descripcion',
        'fecha_creacion',
        'fecha_actualizacion',
        'version',
    ];

    protected $casts = [
        'convenio_id' => 'integer',
        'descripcion' => 'string',
        'fecha_creacion' => 'datetime',
        'fecha_actualizacion' => 'datetime',
        'version' => 'integer',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function convenio(): BelongsTo
    {
        return $this->belongsTo(Convenio::class, 'convenio_id');
    }
}
