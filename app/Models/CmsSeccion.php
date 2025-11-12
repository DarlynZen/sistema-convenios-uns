<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CmsSeccion extends Model
{
    protected $table = 'cms_secciones';

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
