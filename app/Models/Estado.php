<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $nombre
 * @property string|null $descripcion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Convenio> $convenios
 * @property-read int|null $convenios_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Estado newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Estado newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Estado query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Estado whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Estado whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Estado whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Estado whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Estado whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Estado extends Model
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
}
