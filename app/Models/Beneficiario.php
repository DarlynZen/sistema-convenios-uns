<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function convenios(): BelongsToMany
    {
        return $this->belongsToMany(Convenio::class);
    }

    /**
     * Obtiene todos los beneficiarios
     */
    public static function getAll()
    {
        return self::all();
    }
}
