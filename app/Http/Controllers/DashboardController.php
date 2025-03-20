<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\Marca;
use App\Models\Modelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Conteos totales
        $totalArticulos = Articulo::count();
        $totalMarcas = Marca::count();
        $totalModelos = Modelo::count();

        // Artículos por estado
        $articulosPorEstado = Articulo::select('estado', DB::raw('count(*) as total'))
                            ->groupBy('estado')
                            ->get()
                            ->pluck('total', 'estado')
                            ->toArray();

        // Artículos por marca (top 5)
        $articulosPorMarca = DB::table('articulos')
                            ->join('modelos', 'articulos.modelo_id', '=', 'modelos.id')
                            ->join('marcas', 'modelos.marca_id', '=', 'marcas.id')
                            ->select('marcas.id', 'marcas.nombre', DB::raw('count(*) as articulos_count'))
                            ->groupBy('marcas.id', 'marcas.nombre')
                            ->orderByRaw('count(*) DESC')
                            ->take(5)
                            ->get();

        // Últimos artículos añadidos
        $ultimosArticulos = Articulo::with(['modelo.marca'])
                            ->latest()
                            ->take(5)
                            ->get();

        return view('dashboard', compact(
            'totalArticulos',
            'totalMarcas', 
            'totalModelos',
            'articulosPorEstado',
            'articulosPorMarca',
            'ultimosArticulos'
        ));
    }
}