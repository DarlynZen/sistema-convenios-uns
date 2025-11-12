<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function convenios(): HasMany
    {
        return $this->hasMany(Convenio::class);
    }
}
