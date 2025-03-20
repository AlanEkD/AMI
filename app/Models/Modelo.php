<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Modelo extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion', 'marca_id'];

    // Desactiva timestamps para evitar el error de `updated_at`
    public $timestamps = false;

    // Relación: Un modelo pertenece a una marca
    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    // Relación: Un modelo tiene muchos artículos
    public function articulos()
    {
        return $this->hasMany(Articulo::class);
    }
}
