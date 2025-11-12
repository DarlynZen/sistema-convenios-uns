<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoConvenio extends Model
{
    protected $table = 'tipos_convenio';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
