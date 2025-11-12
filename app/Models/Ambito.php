<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ambito extends Model
{
    protected $table = 'ambitos';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
