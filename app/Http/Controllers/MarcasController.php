<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class MarcasController extends Controller
{
    /**
     * Muestra la lista de marcas con paginación.
     */
    public function index(Request $request)
    {
        $query = Marca::query()->withCount('modelos');
        
        // Búsqueda por nombre
        if ($request->has('search') && !empty($request->search)) {
            $query->where('nombre', 'like', "%{$request->search}%");
        }
        
        // Ordenar
        $orderBy = $request->get('order_by', 'nombre');
        $orderDirection = $request->get('order', 'asc');
        $query->orderBy($orderBy, $orderDirection);
        
        $marcas = $query->paginate(15);
        
        return view('CRUD.MARCAS.index', compact('marcas'));
    }

    /**
     * Muestra el formulario para crear una nueva marca.
     */
    public function create()
    {
        return view('CRUD.MARCAS.create');
    }

    /**
     * Guarda una nueva marca en la base de datos.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:marcas,nombre',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
            'descripcion' => 'nullable|string|max:500'
        ]);

        DB::beginTransaction();

        try {
            $marca = new Marca();
            $marca->nombre = $validated['nombre'];
            $marca->descripcion = $validated['descripcion'] ?? null;

            // Guardar el logo si se sube
            if ($request->hasFile('logo')) {
                $marca->logo = $this->handleLogoUpload($request, $marca);
            }

            $marca->save();
            
            DB::commit();
            
            // Verificar si es una solicitud AJAX (desde el modal en creación de artículos)
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'marca' => $marca
                ]);
            }
            
            return redirect()->route('marcas.index')->with('success', 'Marca creada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Si hubo un error y se subió un logo, eliminar el archivo
            if (isset($marca->logo) && Storage::disk('public')->exists($marca->logo)) {
                Storage::disk('public')->delete($marca->logo);
            }
            
            // Si es una solicitud AJAX
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear la marca: ' . $e->getMessage()
                ], 422);
            }
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear la marca: ' . $e->getMessage());
        }
    }

    /**
     * Muestra el formulario para editar una marca.
     */
    public function edit(Marca $marca)
    {
        return view('CRUD.MARCAS.edit', compact('marca'));
    }

    /**
     * Actualiza una marca existente.
     */
    public function update(Request $request, Marca $marca)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:marcas,nombre,' . $marca->id,
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
            'descripcion' => 'nullable|string|max:500'
        ]);

        DB::beginTransaction();

        try {
            $marca->nombre = $validated['nombre'];
            $marca->descripcion = $validated['descripcion'] ?? null;

            // Actualizar el logo si se sube una nueva imagen
            if ($request->hasFile('logo')) {
                $marca->logo = $this->handleLogoUpload($request, $marca);
            }

            $marca->save();
            
            DB::commit();
            return redirect()->route('marcas.index')->with('success', 'Marca actualizada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar la marca: ' . $e->getMessage());
        }
    }

    /**
     * Elimina una marca de la base de datos.
     */
    public function destroy(Marca $marca)
    {
        // Verificar si tiene modelos asociados
        if ($marca->modelos()->count() > 0) {
            return redirect()->route('marcas.index')
                ->with('error', 'No se puede eliminar la marca porque tiene modelos asociados.');
        }

        DB::beginTransaction();

        try {
            // Eliminar el logo si existe
            if ($marca->logo) {
                Storage::disk('public')->delete($marca->logo);
            }

            $marca->delete();
            
            DB::commit();
            return redirect()->route('marcas.index')->with('success', 'Marca eliminada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('marcas.index')
                ->with('error', 'Error al eliminar la marca: ' . $e->getMessage());
        }
    }

    /**
     * Maneja la carga de logos
     * 
     * @param Request $request
     * @param Marca $marca
     * @return string Ruta del logo guardado
     */
    private function handleLogoUpload(Request $request, Marca $marca)
    {
        if ($request->hasFile('logo')) {
            // Eliminar el logo anterior si existe
            if ($marca->logo && Storage::disk('public')->exists($marca->logo)) {
                Storage::disk('public')->delete($marca->logo);
            }
            
            // Procesar y guardar el nuevo logo
            $logoFile = $request->file('logo');
            $filename = 'marca_' . time() . '_' . uniqid() . '.' . $logoFile->getClientOriginalExtension();
            
            return $logoFile->storeAs('logos', $filename, 'public');
        }
        
        return $marca->logo; // Mantener el logo existente
    }
}