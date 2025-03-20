<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use App\Models\Marca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModelosController extends Controller
{
    /**
     * Muestra la lista de modelos con paginación y filtros.
     */
    public function index(Request $request)
    {
        $query = Modelo::with('marca')->withCount('articulos');
        
        // Filtro por nombre
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%")
                  ->orWhereHas('marca', function($subQ) use ($search) {
                      $subQ->where('nombre', 'like', "%{$search}%");
                  });
            });
        }
        
        // Filtro por marca
        if ($request->has('marca_id') && !empty($request->marca_id)) {
            $query->where('marca_id', $request->marca_id);
        }
        
        // Ordenar
        $orderBy = $request->get('order_by', 'nombre');
        $orderDirection = $request->get('order', 'asc');
        $query->orderBy($orderBy, $orderDirection);
        
        $modelos = $query->paginate(15);
        $marcas = Marca::pluck('nombre', 'id');
        
        return view('CRUD.MODELOS.index', compact('modelos', 'marcas'));
    }

    /**
     * Muestra el formulario para crear un nuevo modelo.
     */
    public function create()
    {
        $marcas = Marca::orderBy('nombre')->get();
        return view('CRUD.MODELOS.create', compact('marcas'));
    }

    /**
     * Guarda un nuevo modelo en la base de datos.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:modelos,nombre,NULL,id,marca_id,' . $request->marca_id,
            'descripcion' => 'nullable|string|max:1000',
            'marca_id' => 'required|exists:marcas,id'
        ]);

        try {
            Modelo::create($validated);
            return redirect()->route('modelos.index')->with('success', 'Modelo agregado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear el modelo: ' . $e->getMessage());
        }
    }

    /**
     * Muestra el formulario para editar un modelo.
     */
    public function edit(Modelo $modelo)
    {
        $marcas = Marca::orderBy('nombre')->get();
        $modelo->load('articulos'); // Cargar artículos asociados para mostrar el conteo
        return view('CRUD.MODELOS.edit', compact('modelo', 'marcas'));
    }

    /**
     * Actualiza un modelo existente.
     */
    public function update(Request $request, Modelo $modelo)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:modelos,nombre,' . $modelo->id . ',id,marca_id,' . $request->marca_id,
            'descripcion' => 'nullable|string|max:1000',
            'marca_id' => 'required|exists:marcas,id'
        ]);

        try {
            $modelo->update($validated);
            return redirect()->route('modelos.index')->with('success', 'Modelo actualizado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar el modelo: ' . $e->getMessage());
        }
    }

    /**
     * Elimina un modelo de la base de datos.
     */
    public function destroy(Modelo $modelo)
    {
        // Verificar si tiene artículos asociados
        if ($modelo->articulos()->count() > 0) {
            return redirect()->route('modelos.index')
                ->with('error', 'No se puede eliminar el modelo porque tiene artículos asociados.');
        }

        try {
            $modelo->delete();
            return redirect()->route('modelos.index')->with('success', 'Modelo eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('modelos.index')
                ->with('error', 'Error al eliminar el modelo: ' . $e->getMessage());
        }
    }
}