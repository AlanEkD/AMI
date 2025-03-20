<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | AMI Inventory</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0A1F44',
                        accent: '#22c55e'
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Navigation Bar -->
    <nav class="bg-primary text-white shadow-lg">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <div class="bg-gray-200 p-2 rounded-lg"> <!-- Fondo alrededor del logo -->
                    <img src="{{ asset('img/ami logo.png') }}" alt="AMI Logo" class="h-10">
                </div>
                <span class="text-xl font-bold">AMI</span>
            </div>
            <div class="hidden md:flex space-x-8">
                <a href="{{ route('dashboard') }}" class="hover:text-accent transition">Inicio</a>
                <a href="{{ route('articulos.index') }}" class="hover:text-accent transition">Artículos</a>
                <a href="{{ route('marcas.index') }}" class="hover:text-accent transition">Marcas</a>
                <a href="{{ route('modelos.index') }}" class="hover:text-accent transition">Modelos</a>
            </div>
            <div class="md:hidden">
                <button id="mobile-menu-button" class="text-white focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-primary pb-4 px-4">
            <a href="{{ route('dashboard') }}" class="block py-2 hover:text-accent transition">Inicio</a>
            <a href="{{ route('articulos.index') }}" class="block py-2 hover:text-accent transition">Artículos</a>
            <a href="{{ route('marcas.index') }}" class="block py-2 hover:text-accent transition">Marcas</a>
            <a href="{{ route('modelos.index') }}" class="block py-2 hover:text-accent transition">Modelos</a>
        </div>
    </nav>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-primary mb-6">Panel de Control AMI</h1>
            
            <!-- Tarjetas de estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-accent rounded-md p-3">
                                <i class="fas fa-boxes text-white text-xl"></i>
                            </div>
                            <div class="ml-5">
                                <p class="text-sm font-medium text-gray-500 truncate">Total de Artículos</p>
                                <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $totalArticulos }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                <i class="fas fa-building text-white text-xl"></i>
                            </div>
                            <div class="ml-5">
                                <p class="text-sm font-medium text-gray-500 truncate">Total de Marcas</p>
                                <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $totalMarcas }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                                <i class="fas fa-layer-group text-white text-xl"></i>
                            </div>
                            <div class="ml-5">
                                <p class="text-sm font-medium text-gray-500 truncate">Total de Modelos</p>
                                <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $totalModelos }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Distribución por Estado -->
            <div class="bg-white rounded-lg shadow mb-8">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Distribución por Estado</h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="bg-green-100 p-4 rounded-lg border-l-4 border-green-500">
                            <h5 class="text-green-700 font-semibold">Disponibles</h5>
                            <p class="text-2xl text-green-600">{{ $articulosPorEstado['Disponible'] ?? 0 }}</p>
                        </div>
                        <div class="bg-yellow-100 p-4 rounded-lg border-l-4 border-yellow-500">
                            <h5 class="text-yellow-700 font-semibold">Asignados</h5>
                            <p class="text-2xl text-yellow-600">{{ $articulosPorEstado['Asignado'] ?? 0 }}</p>
                        </div>
                        <div class="bg-orange-100 p-4 rounded-lg border-l-4 border-orange-500">
                            <h5 class="text-orange-700 font-semibold">En Reparación</h5>
                            <p class="text-2xl text-orange-600">{{ $articulosPorEstado['En reparación'] ?? 0 }}</p>
                        </div>
                        <div class="bg-red-100 p-4 rounded-lg border-l-4 border-red-500">
                            <h5 class="text-red-700 font-semibold">De Baja</h5>
                            <p class="text-2xl text-red-600">{{ $articulosPorEstado['Baja'] ?? 0 }}</p>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <canvas id="estadoChart" height="200"></canvas>
                    </div>
                </div>
            </div>
            
            <div class="mb-8">
                <!-- Artículos por Marca -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Top Marcas</h3>
                    </div>
                    <div class="px-4 py-5 sm:p-6">
                        @foreach($articulosPorMarca as $marca)
                            <div class="mb-4 last:mb-0">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-gray-700">{{ $marca->nombre }}</span>
                                    <span class="text-gray-500 text-sm">{{ $marca->articulos_count }} artículos</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-accent h-2 rounded-full" style="width: {{ ($marca->articulos_count / $totalArticulos) * 100 }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <!-- Últimos Artículos Añadidos -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Últimos Artículos Añadidos</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Modelo
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Marca
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Estado
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Fecha
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($ultimosArticulos as $articulo)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $articulo->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $articulo->modelo->nombre }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $articulo->modelo->marca->nombre ?? 'Sin marca' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($articulo->estado == 'Disponible') bg-green-100 text-green-800
                                            @elseif($articulo->estado == 'Asignado') bg-yellow-100 text-yellow-800
                                            @elseif($articulo->estado == 'En reparación') bg-orange-100 text-orange-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ $articulo->estado }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $articulo->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                        <a href="{{ route('articulos.edit', $articulo) }}" class="text-blue-600 hover:text-blue-900">Editar</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Enlaces Rápidos -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('articulos.index') }}" class="bg-primary hover:bg-blue-800 text-white p-4 rounded-lg shadow flex items-center justify-center transition duration-300">
                    <i class="fas fa-boxes mr-2"></i> Ver Todos los Artículos
                </a>
                <a href="{{ route('articulos.create') }}" class="bg-accent hover:bg-green-600 text-white p-4 rounded-lg shadow flex items-center justify-center transition duration-300">
                    <i class="fas fa-plus mr-2"></i> Agregar Nuevo Artículo
                </a>
                <a href="{{ route('marcas.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white p-4 rounded-lg shadow flex items-center justify-center transition duration-300">
                    <i class="fas fa-building mr-2"></i> Gestionar Marcas
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-primary text-white py-6 mt-12">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <div class="flex items-center mb-2">
                        <div class="bg-gray-200 p-2 rounded-lg mr-2">
                            <img src="{{ asset('img/ami logo.png') }}" alt="AMI Logo" class="h-8">
                        </div>
                        <span class="font-bold text-lg">AMI</span>
                    </div>
                    <p class="text-sm">© {{ date('Y') }} AMI. Todos los derechos reservados.</p>
                </div>
                <div class="flex space-x-4">
                    <a href="#" class="text-white hover:text-accent transition">Términos</a>
                    <a href="#" class="text-white hover:text-accent transition">Privacidad</a>
                    <a href="#" class="text-white hover:text-accent transition">Contacto</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle mobile menu
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
        
        // Gráfico de estados
        const ctx = document.getElementById('estadoChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Disponible', 'Asignado', 'En reparación', 'Baja'],
                datasets: [{
                    data: [
                        {{ $articulosPorEstado['Disponible'] ?? 0 }},
                        {{ $articulosPorEstado['Asignado'] ?? 0 }},
                        {{ $articulosPorEstado['En reparación'] ?? 0 }},
                        {{ $articulosPorEstado['Baja'] ?? 0 }}
                    ],
                    backgroundColor: [
                        'rgba(34, 197, 94, 0.7)',
                        'rgba(234, 179, 8, 0.7)',
                        'rgba(249, 115, 22, 0.7)',
                        'rgba(239, 68, 68, 0.7)'
                    ],
                    borderColor: [
                        'rgba(34, 197, 94, 1)',
                        'rgba(234, 179, 8, 1)',
                        'rgba(249, 115, 22, 1)',
                        'rgba(239, 68, 68, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    title: {
                        display: true,
                        text: 'Distribución por Estado'
                    }
                }
            }
        });
    });
    </script>
</body>
</html>