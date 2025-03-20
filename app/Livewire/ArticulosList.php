<?php

// Ejemplo de componente Livewire para la lista de artículos con filtros
namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Articulo;
use App\Models\Marca;
use App\Models\Modelo;
use App\Models\Ubicacion;
use Livewire\WithPagination;

class ArticulosList extends Component
{
    use WithPagination;
    
    public $search = '';
    public $estado = '';
    public $marca_id = '';
    public $modelo_id = '';
    public $ubicacion_id = '';
    
    protected $queryString = ['search', 'estado', 'marca_id', 'modelo_id', 'ubicacion_id'];
    
    // Ejecutado cuando cualquier propiedad cambia
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        $query = Articulo::with('modelo.marca', 'ubicacion');
        
        if ($this->search) {
            $query->search($this->search);
        }
        
        if ($this->estado) {
            $query->estado($this->estado);
        }
        
        if ($this->marca_id) {
            $query->marca($this->marca_id);
        }
        
        if ($this->modelo_id) {
            $query->where('modelo_id', $this->modelo_id);
        }
        
        if ($this->ubicacion_id) {
            $query->ubicacion($this->ubicacion_id);
        }
        
        $articulos = $query->latest()->paginate(15);
        
        return view('livewire.articulos-list', [
            'articulos' => $articulos,
            'marcas' => Marca::pluck('nombre', 'id'),
            'modelos' => Modelo::when($this->marca_id, function($q) {
                            $q->where('marca_id', $this->marca_id);
                         })->pluck('nombre', 'id'),
            'ubicaciones' => Ubicacion::pluck('nombre', 'id'),
            'estados' => Articulo::ESTADOS
        ]);
    }

    public function delete($id)
{
    $articulo = Articulo::find($id);
    if ($articulo) {
        $articulo->delete();
        session()->flash('success', 'Artículo eliminado correctamente.');
    }
}
}