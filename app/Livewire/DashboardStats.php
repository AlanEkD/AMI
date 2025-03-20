<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Articulo;
use App\Models\Marca;
use App\Models\Modelo;

class DashboardStats extends Component
{
    public function render()
    {
        return view('livewire.dashboard-stats', [
            'totalArticulos' => Articulo::count(),
            'totalMarcas' => Marca::count(),
            'totalModelos' => Modelo::count(),
            'articulosDisponibles' => Articulo::where('estado', 'Disponible')->count(),
            'articulosAsignados' => Articulo::where('estado', 'Asignado')->count(),
            'articulosEnReparacion' => Articulo::where('estado', 'En reparación')->count(),
            'articulosBaja' => Articulo::where('estado', 'Baja')->count(),
            'ultimosArticulos' => Articulo::with('modelo.marca', 'ubicacion')->latest()->take(5)->get()
        ]);
    }
}