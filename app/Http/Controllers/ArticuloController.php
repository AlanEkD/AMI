<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\Modelo;
use App\Models\Marca;
use App\Models\Ubicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\ArticulosExport;
use Maatwebsite\Excel\Facades\Excel;

class ArticuloController extends Controller
{
    /**
     * Muestra la lista de artículos con filtros y paginación.
     */
    public function index(Request $request)
    {
        $query = Articulo::with('modelo.marca', 'ubicacion');
        
        // Filtro de búsqueda
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('modelo', function($subQ) use ($search) {
                    $subQ->where('nombre', 'like', "%{$search}%");
                })
                ->orWhereHas('modelo.marca', function($subQ) use ($search) {
                    $subQ->where('nombre', 'like', "%{$search}%");
                })
                ->orWhere('numero_serie', 'like', "%{$search}%");
            });
        }
        
        // Filtro por estado
        if ($request->has('estado') && !empty($request->estado)) {
            $query->where('estado', $request->estado);
        }
        
        // Filtro por ubicación
        if ($request->has('ubicacion_id') && !empty($request->ubicacion_id)) {
            $query->where('ubicacion_id', $request->ubicacion_id);
        }
        
        // Filtro por marca
        if ($request->has('marca_id') && !empty($request->marca_id)) {
            $query->whereHas('modelo', function($q) use ($request) {
                $q->where('marca_id', $request->marca_id);
            });
        }
        
        // Ordenar por
        $orderBy = $request->get('order_by', 'created_at');
        $orderDirection = $request->get('order', 'desc');
        $query->orderBy($orderBy, $orderDirection);
        
        $articulos = $query->paginate(15);
        
        // Pasar estados disponibles para los filtros
        $estados = [
            'Disponible' => 'Disponible',
            'Asignado' => 'Asignado',
            'En reparación' => 'En reparación',
            'Baja' => 'Baja'
        ];
        
        $ubicaciones = Ubicacion::pluck('nombre', 'id')->toArray();
        $marcas = Marca::pluck('nombre', 'id')->toArray();
        
        return view('CRUD.ARTICULOS.index', compact('articulos', 'estados', 'ubicaciones', 'marcas'));
    }

    /**
     * Muestra el formulario para crear un nuevo artículo.
     */
    public function create()
    {
        $modelos = Modelo::with('marca')->get();
        $ubicaciones = Ubicacion::all();
        $marcas = Marca::all();
        
        $estados = [
            'Disponible' => 'Disponible',
            'Asignado' => 'Asignado',
            'En reparación' => 'En reparación',
            'Baja' => 'Baja'
        ];

        return view('CRUD.ARTICULOS.create', compact('modelos', 'ubicaciones', 'marcas', 'estados'));
    }

    /**
     * Almacena un nuevo artículo en la base de datos.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'modelo_nombre' => 'required|string|max:255',
            'marca_id' => 'required|exists:marcas,id',
            'numero_serie' => 'nullable|string|max:255|unique:articulos,numero_serie',
            'estado' => 'required|in:Disponible,Asignado,En reparación,Baja',
            'ubicacion_id' => 'nullable|exists:ubicaciones,id',
            'fecha_ingreso' => 'required|date',
        ]);

        DB::beginTransaction();
        
        try {
            // Buscar o crear el modelo con la técnica firstOrCreate
            $modelo = Modelo::firstOrCreate(
                ['nombre' => $validated['modelo_nombre']],
                [
                    'descripcion' => "Modelo agregado automáticamente",
                    'marca_id' => $validated['marca_id']
                ]
            );
            
            // Crear el artículo
            Articulo::create([
                'modelo_id' => $modelo->id,
                'numero_serie' => $validated['numero_serie'],
                'estado' => $validated['estado'],
                'ubicacion_id' => $validated['ubicacion_id'],
                'fecha_ingreso' => $validated['fecha_ingreso'],
            ]);
            
            DB::commit();
            return redirect()->route('articulos.index')->with('success', 'Artículo agregado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear el artículo: ' . $e->getMessage());
        }
    }

    /**
     * Muestra el formulario para editar un artículo existente usando Route Model Binding.
     */
    public function edit(Articulo $articulo)
    {
        $modelos = Modelo::all();
        $ubicaciones = Ubicacion::all();
        
        $estados = [
            'Disponible' => 'Disponible',
            'Asignado' => 'Asignado',
            'En reparación' => 'En reparación',
            'Baja' => 'Baja'
        ];
        
        return view('CRUD.ARTICULOS.edit', compact('articulo', 'modelos', 'ubicaciones', 'estados'));
    }

    /**
     * Actualiza un artículo en la base de datos.
     */
    public function update(Request $request, Articulo $articulo)
    {
        $validated = $request->validate([
            'modelo_id' => 'required|exists:modelos,id',
            'numero_serie' => 'nullable|string|max:255|unique:articulos,numero_serie,' . $articulo->id,
            'estado' => 'required|in:Disponible,Asignado,En reparación,Baja',
            'ubicacion_id' => 'nullable|exists:ubicaciones,id',
            'fecha_ingreso' => 'required|date',
        ]);

        try {
            $articulo->update($validated);
            return redirect()->route('articulos.index')->with('success', 'Artículo actualizado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar el artículo: ' . $e->getMessage());
        }
    }

    /**
     * Elimina un artículo de la base de datos.
     */
    public function destroy(Articulo $articulo)
    {
        try {
            $articulo->delete();
            return redirect()->route('articulos.index')->with('success', 'Artículo eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('articulos.index')
                ->with('error', 'Error al eliminar el artículo: ' . $e->getMessage());
        }
    }
    
    /**
     * Exporta la lista de artículos a Excel con los filtros aplicados.
     */
    /**
 * Exporta la lista de artículos a CSV con los filtros aplicados.
 */
public function export(Request $request)
{
    // Reutilizamos los filtros de la petición actual
    $filters = [
        'search' => $request->get('search'),
        'estado' => $request->get('estado'),
        'ubicacion_id' => $request->get('ubicacion_id'),
        'marca_id' => $request->get('marca_id'),
        'order_by' => $request->get('order_by', 'created_at'),
        'order' => $request->get('order', 'desc')
    ];
    
    // Nombre del archivo con fecha y hora
    $filename = 'inventario_ami_' . date('Y-m-d_H-i-s') . '.csv';
    
    // Usar la clase simplificada
    $exporter = new \App\Exports\ArticulosExport($filters);
    return $exporter->download($filename);
}
}