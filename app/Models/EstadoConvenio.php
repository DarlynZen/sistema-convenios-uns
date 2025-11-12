<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function convenios(): HasMany
    {
        return $this->hasMany(Convenio::class);
    }
}
