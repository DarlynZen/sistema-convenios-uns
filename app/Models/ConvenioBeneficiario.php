<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConvenioBeneficiario extends Model
{
    protected $table = 'convenios_beneficiarios';

    protected $fillable = [
        'convenio_id',
        'beneficiario_id',
    ];

    protected $casts = [
        'convenio_id' => 'integer',
        'beneficiario_id' => 'integer',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
