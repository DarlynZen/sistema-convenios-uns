<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read \App\Models\Convenio|null $convenio
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentoConvenio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentoConvenio newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentoConvenio query()
 * @mixin \Eloquent
 */
class DocumentoConvenio extends Model
{
    // Alineado con la migración: 'documentos_convenio'
    protected $table = 'documentos_convenio';

    protected $fillable = [
        'convenio_id',
        'tipo_documento',
        'nombre_archivo',
        'ruta_archivo',
        'version',
        'activo',
        'observaciones',
    ];

    protected $casts = [
        'convenio_id' => 'integer',
        'tipo_documento' => 'string',
        'nombre_archivo' => 'string',
        'ruta_archivo' => 'string',
        'version' => 'integer',
        'activo' => 'boolean',
        'observaciones' => 'string',
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
