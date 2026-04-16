<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $nombre
 * @property string $codigo_beneficiario
 * @property string|null $descripcion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Convenio> $convenios
 * @property-read int|null $convenios_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Beneficiario newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Beneficiario newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Beneficiario query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Beneficiario whereCodigoBeneficiario($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Beneficiario whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Beneficiario whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Beneficiario whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Beneficiario whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Beneficiario whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Beneficiario extends Model
{
    protected $table = 'beneficiarios';

    protected $fillable = [
        'nombre',
        'codigo_beneficiario',
        'descripcion',
        'estado',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function convenios(): BelongsToMany
    {
        return $this->belongsToMany(Convenio::class);
    }
}
