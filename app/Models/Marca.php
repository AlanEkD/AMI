<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Marca extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = ['nombre', 'logo'];

    public $timestamps = false; // Desactiva `created_at` y `updated_at`

    // Relación: Una marca tiene muchos modelos
    public function modelos()
    {
        return $this->hasMany(Modelo::class);
    }
}
