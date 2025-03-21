<?php

namespace App\Exports;

use App\Models\Articulo;

class ArticulosExport 
{
    protected $filters;
    
    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }
    
    public function download($filename)
    {
        // Iniciar el archivo CSV
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        // Crear un recurso de archivo PHP
        $output = fopen('php://output', 'w');
        
        // Codificar para UTF-8 y usar ; como separador para mejor compatibilidad con Excel
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM para UTF-8
        
        // Añadir encabezados
        fputcsv($output, [
            'ID',
            'Identificador',
            'Modelo',
            'Marca',
            'Número de Serie',
            'Estado',
            'Ubicación',
            'Empaque Original',
            'Fecha de Ingreso',
            'Última Actualización'
        ], ';');
        
        // Consultar los datos con los filtros
        $query = Articulo::with('modelo.marca', 'ubicacion');
        
        // Filtro de búsqueda
        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->search($search);
        }
        
        // Filtro por estado
        if (!empty($this->filters['estado'])) {
            $query->estado($this->filters['estado']);
        }
        
        // Filtro por ubicación
        if (!empty($this->filters['ubicacion_id'])) {
            $query->ubicacion($this->filters['ubicacion_id']);
        }
        
        // Filtro por marca
        if (!empty($this->filters['marca_id'])) {
            $query->marca($this->filters['marca_id']);
        }
        
        // Ordenar por
        $orderBy = $this->filters['order_by'] ?? 'created_at';
        $orderDirection = $this->filters['order'] ?? 'desc';
        $query->orderBy($orderBy, $orderDirection);
        
        // Obtener los resultados e iterar
        $articulos = $query->get();
        
        foreach ($articulos as $articulo) {
            // Mapear cada artículo a una fila del CSV
            fputcsv($output, [
                $articulo->id,
                $articulo->identificador ?? 'N/A',
                $articulo->modelo ? $articulo->modelo->nombre : 'N/A',
                $articulo->modelo && $articulo->modelo->marca ? $articulo->modelo->marca->nombre : 'Sin marca',
                $articulo->numero_serie ?? 'N/A',
                $articulo->estado,
                $articulo->ubicacion ? $articulo->ubicacion->nombre : 'Sin ubicación',
                $articulo->empaque_original ? 'Sí' : 'No',
                $articulo->fecha_ingreso ? $articulo->fecha_ingreso->format('d/m/Y') : 'N/A',
                $articulo->updated_at ? $articulo->updated_at->format('d/m/Y H:i:s') : 'N/A'
            ], ';');
        }
        
        fclose($output);
        exit;
    }
}