<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    use HasFactory;

    protected $fillable = ['articulo_id', 'tipo_movimiento', 'fecha', 'usuario', 'comentario'];

    // Relación: Un movimiento pertenece a un artículo
    public function articulo()
    {
        return $this->belongsTo(Articulo::class);
    }
}
