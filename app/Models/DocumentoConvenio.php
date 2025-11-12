<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentoConvenio extends Model
{
    protected $table = 'documentos_convenios';

    protected $fillable = [
        'convenio_id',
        'tipo_documento',
        'nombre_documento',
        'ruta_documento',
        'version',
        'activo',
        'observaciones',
    ];

    protected $casts = [
        'convenio_id' => 'integer',
        'tipo_documento' => 'string',
        'nombre_documento' => 'string',
        'ruta_documento' => 'string',
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
