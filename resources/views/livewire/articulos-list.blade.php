<div>
    <!-- Filtros -->
    <div class="bg-white p-4 rounded-lg shadow-sm mb-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Búsqueda general -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                <input 
                    type="text" 
                    wire:model.debounce.300ms="search" 
                    placeholder="Buscar por modelo, marca, número de serie..." 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent"
                >
            </div>
            
            <!-- Filtro por estado -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                <select 
                    wire:model="estado" 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent appearance-none"
                >
                    <option value="">Todos los estados</option>
                    @foreach($estados as $estadoValue)
                        <option value="{{ $estadoValue }}">{{ $estadoValue }}</option>
                    @endforeach
                </select>
            </div>
            
            <!-- Filtro por marca -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Marca</label>
                <select 
                    wire:model="marca_id" 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent appearance-none"
                >
                    <option value="">Todas las marcas</option>
                    @foreach($marcas as $id => $nombre)
                        <option value="{{ $id }}">{{ $nombre }}</option>
                    @endforeach
                </select>
            </div>
            
            <!-- Filtro por ubicación -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ubicación</label>
                <select 
                    wire:model="ubicacion_id" 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent appearance-none"
                >
                    <option value="">Todas las ubicaciones</option>
                    @foreach($ubicaciones as $id => $nombre)
                        <option value="{{ $id }}">{{ $nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    
    <!-- Tabla de resultados -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-700 text-sm uppercase tracking-wider">
                    <th class="px-4 py-3 text-left">ID</th>
                    <th class="px-4 py-3 text-left">Modelo</th>
                    <th class="px-4 py-3 text-left">Marca</th>
                    <th class="px-4 py-3 text-left">Número de Serie</th>
                    <th class="px-4 py-3 text-left">Estado</th>
                    <th class="px-4 py-3 text-left">Ubicación</th>
                    <th class="px-4 py-3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($articulos as $articulo)
                <tr class="border-t border-gray-200 hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3 whitespace-nowrap">{{ $articulo->id }}</td>
                    <td class="px-4 py-3 font-medium">{{ $articulo->modelo->nombre }}</td>
                    <td class="px-4 py-3">{{ $articulo->modelo->marca->nombre ?? 'Sin marca' }}</td>
                    <td class="px-4 py-3">{{ $articulo->numero_serie ?? 'N/A' }}</td>
                    <td class="px-4 py-3">
                        <span class="px-3 py-1 rounded text-white text-xs font-semibold
                            @if($articulo->estado == 'Disponible') bg-green-500
                            @elseif($articulo->estado == 'Asignado') bg-yellow-500
                            @elseif($articulo->estado == 'En reparación') bg-orange-500
                            @else bg-red-500
                            @endif">
                            {{ $articulo->estado }}
                        </span>
                    </td>
                    <td class="px-4 py-3">{{ $articulo->ubicacion->nombre ?? 'Sin ubicación' }}</td>
                    <td class="px-4 py-3 text-center">
                        <div class="flex justify-center items-center space-x-2">
                            <a href="{{ route('articulos.edit', $articulo) }}" class="bg-blue-500 hover:bg-blue-600 text-white p-2 rounded transition">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button 
                                type="button" 
                                onclick="confirm('¿Está seguro de eliminar este artículo?') || event.stopImmediatePropagation()"
                                wire:click="delete({{ $articulo->id }})" 
                                class="bg-red-500 hover:bg-red-600 text-white p-2 rounded transition">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
                
                @if($articulos->isEmpty())
                <tr>
                    <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                        No se encontraron artículos con los criterios de búsqueda.
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
        
        <!-- Paginación -->
        <div class="px-4 py-3 border-t">
            {{ $articulos->links() }}
        </div>
    </div>
</div>