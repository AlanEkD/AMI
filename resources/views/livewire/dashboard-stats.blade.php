<div>
    <!-- Estadísticas principales -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-primary text-white p-4 rounded-lg">
            <h4 class="font-bold mb-1">Total Artículos</h4>
            <p class="text-2xl">{{ $totalArticulos }}</p>
        </div>
        <div class="bg-accent text-white p-4 rounded-lg">
            <h4 class="font-bold mb-1">Marcas Registradas</h4>
            <p class="text-2xl">{{ $totalMarcas }}</p>
        </div>
        <div class="bg-blue-500 text-white p-4 rounded-lg">
            <h4 class="font-bold mb-1">Modelos Disponibles</h4>
            <p class="text-2xl">{{ $totalModelos }}</p>
        </div>
    </div>
    
    <!-- Estado de Artículos -->
    <div class="bg-gray-100 rounded-lg p-4">
        <h4 class="font-bold text-primary mb-2">Estado de Artículos</h4>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
            <div class="bg-green-100 p-4 rounded-lg border-l-4 border-green-500">
                <h5 class="text-green-700 font-semibold">Disponibles</h5>
                <p class="text-xl text-green-600">{{ $articulosDisponibles }}</p>
            </div>
            <div class="bg-yellow-100 p-4 rounded-lg border-l-4 border-yellow-500">
                <h5 class="text-yellow-700 font-semibold">Asignados</h5>
                <p class="text-xl text-yellow-600">{{ $articulosAsignados }}</p>
            </div>
            <div class="bg-orange-100 p-4 rounded-lg border-l-4 border-orange-500">
                <h5 class="text-orange-700 font-semibold">En Reparación</h5>
                <p class="text-xl text-orange-600">{{ $articulosEnReparacion }}</p>
            </div>
            <div class="bg-red-100 p-4 rounded-lg border-l-4 border-red-500">
                <h5 class="text-red-700 font-semibold">De Baja</h5>
                <p class="text-xl text-red-600">{{ $articulosBaja }}</p>
            </div>
        </div>
    </div>
    
    <!-- Últimos artículos añadidos -->
    @if($ultimosArticulos->count() > 0)
    <div class="mt-6 bg-white p-4 rounded-lg shadow">
        <h4 class="font-bold text-primary mb-4">Últimos Artículos Añadidos</h4>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-4 py-2 text-left">ID</th>
                        <th class="px-4 py-2 text-left">Modelo</th>
                        <th class="px-4 py-2 text-left">Marca</th>
                        <th class="px-4 py-2 text-left">Estado</th>
                        <th class="px-4 py-2 text-left">Fecha Ingreso</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ultimosArticulos as $articulo)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $articulo->id }}</td>
                        <td class="px-4 py-2">{{ $articulo->modelo->nombre }}</td>
                        <td class="px-4 py-2">{{ $articulo->modelo->marca->nombre ?? 'Sin marca' }}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded text-xs font-semibold
                                @if($articulo->estado == 'Disponible') bg-green-500 text-white
                                @elseif($articulo->estado == 'Asignado') bg-yellow-500 text-white
                                @elseif($articulo->estado == 'En reparación') bg-orange-500 text-white
                                @else bg-red-500 text-white @endif">
                                {{ $articulo->estado }}
                            </span>
                        </td>
                        <td class="px-4 py-2">{{ $articulo->fecha_ingreso->format('d/m/Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>