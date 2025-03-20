<?php

namespace App\Http\Controllers;

use App\Models\Ubicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UbicacionController extends Controller
{
    /**
     * Muestra la lista de ubicaciones con paginación.
     */
    public function index(Request $request)
    {
        $query = Ubicacion::query()->withCount('articulos');
        
        // Búsqueda por nombre
        if ($request->has('search') && !empty($request->search)) {
            $query->buscar($request->search);
        }
        
        // Ordenar
        $orderBy = $request->get('order_by', 'nombre');
        $orderDirection = $request->get('order', 'asc');
        $query->orderBy($orderBy, $orderDirection);
        
        $ubicaciones = $query->paginate(15);
        
        return view('CRUD.UBICACIONES.index', compact('ubicaciones'));
    }

    /**
     * Muestra el formulario para crear una nueva ubicación.
     */
    public function create()
    {
        return view('CRUD.UBICACIONES.create');
    }

    /**
     * Guarda una nueva ubicación en la base de datos.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:ubicaciones,nombre',
            'descripcion' => 'nullable|string|max:500'
        ]);

        DB::beginTransaction();

        try {
            Ubicacion::create($validated);
            
            DB::commit();
            return redirect()->route('ubicaciones.index')->with('success', 'Ubicación creada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear la ubicación: ' . $e->getMessage());
        }
    }

    /**
     * Muestra el formulario para editar una ubicación.
     */
    public function edit(Ubicacion $ubicacion)
    {
        $ubicacion->load('articulos'); // Cargar artículos relacionados para mostrar conteo
        return view('CRUD.UBICACIONES.edit', compact('ubicacion'));
    }

    /**
     * Actualiza una ubicación existente.
     */
    public function update(Request $request, Ubicacion $ubicacion)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:ubicaciones,nombre,' . $ubicacion->id,
            'descripcion' => 'nullable|string|max:500'
        ]);

        DB::beginTransaction();

        try {
            $ubicacion->update($validated);
            
            DB::commit();
            return redirect()->route('ubicaciones.index')->with('success', 'Ubicación actualizada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar la ubicación: ' . $e->getMessage());
        }
    }

    /**
     * Elimina una ubicación de la base de datos.
     */
    public function destroy(Ubicacion $ubicacion)
    {
        // Verificar si tiene artículos asociados
        if ($ubicacion->articulos()->count() > 0) {
            return redirect()->route('ubicaciones.index')
                ->with('error', 'No se puede eliminar la ubicación porque tiene artículos asociados.');
        }

        DB::beginTransaction();

        try {
            $ubicacion->delete();
            
            DB::commit();
            return redirect()->route('ubicaciones.index')->with('success', 'Ubicación eliminada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('ubicaciones.index')
                ->with('error', 'Error al eliminar la ubicación: ' . $e->getMessage());
        }
    }
}