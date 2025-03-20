<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\Marca;
use App\Models\Modelo;

class WelcomeController extends Controller
{
    public function index()
    {
        // Total counts
        $totalArticulos = Articulo::count();
        $totalMarcas = Marca::count();
        $totalModelos = Modelo::count();

        // Article status counts
        $articulosDisponibles = Articulo::where('estado', 'Disponible')->count();
        $articulosAsignados = Articulo::where('estado', 'Asignado')->count();
        $articulosEnReparacion = Articulo::where('estado', 'En reparación')->count();
        $articulosBaja = Articulo::where('estado', 'Baja')->count();

        return view('welcome', compact(
            'totalArticulos', 
            'totalMarcas', 
            'totalModelos', 
            'articulosDisponibles', 
            'articulosAsignados', 
            'articulosEnReparacion', 
            'articulosBaja'
        ));
    }
}