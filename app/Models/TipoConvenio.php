<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $nombre
 * @property string|null $descripcion
 * @property int $activo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Convenio> $convenios
 * @property-read int|null $convenios_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoConvenio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoConvenio newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoConvenio query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoConvenio whereActivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoConvenio whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoConvenio whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoConvenio whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoConvenio whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoConvenio whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
