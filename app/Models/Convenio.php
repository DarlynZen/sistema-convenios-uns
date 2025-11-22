<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Convenio extends Model
{
    protected $table = 'convenios';

    protected $fillable = [
        'tipo_convenio_id',
        'ambito_id',
        'estado_convenio_id',
        'resolucion',
        'titulo',
        'objetivo_personalizado',
        'fecha_inicio',
        'fecha_fin',
        'plazo_prorroga_valor',
        'plazo_prorroga_unidad',
        'entidad_nombre',
        'entidad_logo',
        'entidad_tipo',
        'nacionalidad',
        'detalles_coordinadores_json',
        'convenio_renovado_de',
    ];

    protected $casts = [
        'tipo_convenio_id' => 'integer',
        'ambito_id' => 'integer',
        'estado_convenio_id' => 'integer',
        'resolucion' => 'string',
        'titulo' => 'string',
        'objetivo_personalizado' => 'string',
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'plazo_prorroga_valor' => 'integer',  //enum ver docs
        'plazo_prorroga_unidad' => 'string',
        'entidad_nombre' => 'string',
        'entidad_logo' => 'string',
        'entidad_tipo' => 'string',
        'nacionalidad' => 'string',
        'detalles_coordinadores_json' => 'array',
        'convenio_renovado_de' => 'integer',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function tipoConvenio(): BelongsTo
    {
        return $this->belongsTo(TipoConvenio::class, 'tipo_convenio_id');
    }

    public function ambito(): BelongsTo
    {
        return $this->belongsTo(Ambito::class, 'ambito_id');
    }

    public function estadoConvenio(): BelongsTo
    {
        return $this->belongsTo(EstadoConvenio::class, 'estado_convenio_id');
    }

    public function documento(): HasMany
    {
        return $this->hasMany(DocumentoConvenio::class);
    }

    public function convenioAnterior(): BelongsTo
    {
        return $this->belongsTo(Convenio::class, 'convenio_renovado_de');
    }

    public function convenioRenovado(): BelongsTo  //obs de HasMany
    {
        return $this->belongsTo(Convenio::class, 'id', 'convenio_renovado_de');
    }

    public function beneficiario(): BelongsToMany
    {
        return $this->belongsToMany(Beneficiario::class, 'convenios_beneficiarios', 'convenio_id', 'beneficiario_id');
    }

    public function observaciones(): HasMany
    {
        return $this->hasMany(Observacion::class);
    }

    public function getDuracionAttribute()
    {
        return $this->fecha_inicio
            ->locale('es')
            ->diffForHumans($this->fecha_fin, true);
    }


    // Métodos de negocio - Lógica de acceso a datos

    /**
     * Obtiene todos los convenios con sus relaciones principales
     */
    public static function getAllWithRelations()
    {
        return self::with(['tipoConvenio', 'ambito', 'estadoConvenio'])
            ->latest()
            ->paginate(15);
    }

    /**
     * Obtiene un convenio con todas sus relaciones
     */
    public function loadAllRelations()
    {
        return $this->load([
            'tipoConvenio',
            'ambito',
            'estadoConvenio',
            'beneficiario',
            'documento',
            'convenioAnterior'
        ]);
    }

    /**
     * Crea un convenio con sus beneficiarios asociados
     */
    public static function createWithBeneficiarios(array $data, ?array $beneficiarios = null)
    {
        $convenio = self::create($data);

        if ($beneficiarios) {
            $convenio->beneficiario()->sync($beneficiarios);
        }

        return $convenio;
    }

    /**
     * Actualiza un convenio y sus beneficiarios
     */
    public function updateWithBeneficiarios(array $data, ?array $beneficiarios = null)
    {
        $this->update($data);

        if ($beneficiarios !== null) {
            $this->beneficiario()->sync($beneficiarios);
        } else {
            $this->beneficiario()->detach();
        }

        return $this->fresh();
    }

    /**
     * Elimina un convenio y limpia sus relaciones
     */
    public function deleteWithRelations()
    {
        $this->beneficiario()->detach();
        return $this->delete();
    }

    // Scopes para consultas comunes

    public function scopeActivos($query)
    {
        return $query->whereHas('estadoConvenio', function ($q) {
            $q->where('nombre', 'like', '%activo%');
        });
    }

    public function scopeRecientes($query, int $limit = 5)
    {
        return $query->with(['tipoConvenio', 'estadoConvenio'])
            ->latest()
            ->limit($limit);
    }

    /**
     * Obtiene estadísticas para el dashboard
     */
    public static function getDashboardStats(): array
    {
        return [
            'total_convenios' => self::count(),
            'convenios_activos' => self::activos()->count(),
            'tipos_convenio' => TipoConvenio::count(),
            'ambitos' => Ambito::count(),
            'recientes' => self::recientes(5)->get(),
        ];
    }
}
