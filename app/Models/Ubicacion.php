<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ubicacion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ubicaciones'; // Asegura que apunte a la tabla correcta

    protected $fillable = ['nombre', 'descripcion'];

    /**
     * Relación: Una ubicación tiene muchos artículos
     */
    public function articulos()
    {
        return $this->hasMany(Articulo::class);
    }

    /**
     * Filtrar ubicaciones por nombre
     */
    public function scopeBuscar($query, $busqueda)
    {
        if ($busqueda) {
            return $query->where('nombre', 'like', "%{$busqueda}%")
                        ->orWhere('descripcion', 'like', "%{$busqueda}%");
        }
        return $query;
    }
}