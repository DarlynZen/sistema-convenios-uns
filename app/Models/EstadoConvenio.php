<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoConvenio extends Model
{
    protected $table = 'estado_convenios';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
