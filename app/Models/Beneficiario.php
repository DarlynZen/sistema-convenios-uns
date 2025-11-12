<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beneficiario extends Model
{
    protected $table = 'beneficiarios';

    protected $fillable = [
        'nombre',
        'codigo_beneficiario',
        'descripcion',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
