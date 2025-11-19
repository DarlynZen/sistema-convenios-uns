<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EstadoConvenio extends Model
{
    protected $table = 'estados_convenio';

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

    /**
     * Obtiene todos los estados de convenio
     */
    public static function getAll()
    {
        return self::all();
    }

    /**
     * Verifica si puede ser eliminado
     */
    public function canBeDeleted(): bool
    {
        return $this->convenios()->count() === 0;
    }
}
