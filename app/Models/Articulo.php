<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Articulo extends Model
{
    use SoftDeletes;
    use HasFactory;
    
    public const ESTADO_DISPONIBLE = 'Disponible';
    public const ESTADO_ASIGNADO = 'Asignado';
    public const ESTADO_REPARACION = 'En reparación';
    public const ESTADO_BAJA = 'Baja';

    public const ESTADOS = [
        self::ESTADO_DISPONIBLE,
        self::ESTADO_ASIGNADO,
        self::ESTADO_REPARACION,
        self::ESTADO_BAJA
    ];

    protected $fillable = [
        'modelo_id', 
        'identificador',
        'numero_serie', 
        'estado', 
        'ubicacion_id', 
        'fecha_ingreso',
        'empaque_original'
    ];

    protected $dates = ['fecha_ingreso'];

    protected static function boot()
    {
        parent::boot();

        // Generar un identificador único al crear un nuevo artículo si no se proporciona uno
        static::creating(function ($articulo) {
            if (!$articulo->identificador) {
                $articulo->identificador = 'AMI-' . date('Ymd') . '-' . strtoupper(Str::random(5));
            }
        });
    }

    // Relación: Un artículo pertenece a un modelo
    public function modelo()
    {
        return $this->belongsTo(Modelo::class);
    }

    // Relación: Un artículo puede estar en una ubicación
    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class);
    }

    // Relación: Un artículo puede tener muchos movimientos
    public function movimientos()
    {
        return $this->hasMany(Movimiento::class);
    }

    // Métodos de consulta (scopes)
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('identificador', 'like', "%{$search}%")
              ->orWhere('numero_serie', 'like', "%{$search}%")
              ->orWhereHas('modelo', function($subQ) use ($search) {
                  $subQ->where('nombre', 'like', "%{$search}%");
              })
              ->orWhereHas('modelo.marca', function($subQ) use ($search) {
                  $subQ->where('nombre', 'like', "%{$search}%");
              });
        });
    }

    public function scopeEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    public function scopeMarca($query, $marcaId)
    {
        return $query->whereHas('modelo', function($q) use ($marcaId) {
            $q->where('marca_id', $marcaId);
        });
    }

    public function scopeUbicacion($query, $ubicacionId)
    {
        return $query->where('ubicacion_id', $ubicacionId);
    }
}