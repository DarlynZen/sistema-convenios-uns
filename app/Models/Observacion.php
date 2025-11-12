<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    /* public function convenio()
    {
        return $this->belongsTo(Convenio::class, 'convenio_id');
    } */
}
