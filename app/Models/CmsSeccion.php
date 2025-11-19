<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    /**
     * Obtiene todas las secciones
     */
    public static function getAll()
    {
        return self::latest()->get();
    }

    /**
     * Busca una sección por slug
     */
    public static function findBySlug(string $slug)
    {
        return self::where('slug', $slug)->first();
    }
}
