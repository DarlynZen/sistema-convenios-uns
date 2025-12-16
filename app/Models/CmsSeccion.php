<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $slug
 * @property string $titulo
 * @property string|null $descripcion
 * @property array<array-key, mixed>|null $contenido_json
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CmsSeccion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CmsSeccion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CmsSeccion query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CmsSeccion whereContenidoJson($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CmsSeccion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CmsSeccion whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CmsSeccion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CmsSeccion whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CmsSeccion whereTitulo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CmsSeccion whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CmsSeccion extends Model
{
    protected $table = 'cms_seccion';

    protected $fillable = [
        'slug',
        'titulo',
        'descripcion',
        'contenido_json',
    ];

    protected function casts(): array
    {
        return [
            'contenido_json' => 'array',
        ];
    }

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
