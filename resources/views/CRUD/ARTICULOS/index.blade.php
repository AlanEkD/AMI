<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Artículos | AMI</title>
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
                <a href="{{ route('welcome') }}" class="hover:text-accent transition">Inicio</a>
                <a href="{{ route('articulos.index') }}" class="hover:text-accent transition">Artículos</a>
                <a href="{{ route('marcas.index') }}" class="hover:text-accent transition">Marcas</a>
                <a href="{{ route('modelos.index') }}" class="hover:text-accent transition">Modelos</a>
                <a href="#" class="hover:text-accent transition">Ubicaciones</a>
                <a href="{{ route('articulos.index') }}" class="hover:text-accent transition">Contacto</a>
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
            <a href="#" class="block py-2 hover:text-accent transition">Inicio</a>
            <a href="#" class="block py-2 hover:text-accent transition font-medium">Artículos</a>
            <a href="#" class="block py-2 hover:text-accent transition">Marcas</a>
            <a href="#" class="block py-2 hover:text-accent transition">Modelos</a>
            <a href="#" class="block py-2 hover:text-accent transition">Contacto</a>
        </div>
    </nav>

    <!-- Page Header -->
    <div class="bg-primary text-white py-6">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold">Gestión de Artículos</h1>
            <p class="mt-2">Administra los artículos disponibles en el inventario</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Header & Actions -->
            <div class="p-6 border-b border-gray-200 flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center">
                    <i class="fas fa-boxes text-primary text-xl mr-3"></i>
                    <h2 class="text-2xl font-bold text-primary">Lista de Artículos</h2>
                </div>
                <div class="flex items-center gap-4 w-full md:w-auto">
                    <div class="relative w-full md:w-64">
                        <input 
                            type="text" 
                            id="searchInput" 
                            placeholder="Buscar artículo..." 
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent"
                        >
                        <span class="absolute right-3 top-2.5 text-gray-400">
                            <i class="fas fa-search"></i>
                        </span>
                    </div>
                    <div class="relative w-full md:w-48">
                        <select 
                            id="estadoFilter" 
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent appearance-none"
                        >
                            <option value="">Todos los estados</option>
                            <option value="Disponible">Disponible</option>
                            <option value="Asignado">Asignado</option>
                            <option value="En reparación">En reparación</option>
                            <option value="De baja">De baja</option>
                        </select>
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 pointer-events-none">
                            <i class="fas fa-chevron-down"></i>
                        </span>
                    </div>
                    <a href="{{ route('articulos.create') }}" class="bg-accent hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg transition flex items-center whitespace-nowrap">
                        <i class="fas fa-plus mr-2"></i> Nuevo Artículo
                    </a>
                    <a href="{{ route('articulos.export') }}?{{ http_build_query(request()->query()) }}" 
                        class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition flex items-center">
                         <i class="fas fa-file-excel mr-2"></i> Exportar a CSV
                     </a>
                </div>
            </div>
            
            <!-- Table Section -->
            <div class="overflow-x-auto">
                <table class="w-full border-collapse" id="articulosTable">
                    <thead>
                        <tr class="bg-gray-50 text-gray-700 text-sm uppercase tracking-wider">
                            <th class="px-4 py-3 text-left">ID</th>
                            <th class="px-4 py-3 text-left cursor-pointer hover:text-accent" onclick="sortTable(1)">
                                Modelo <i class="fas fa-sort ml-1"></i>
                            </th>
                            <th class="px-4 py-3 text-left cursor-pointer hover:text-accent" onclick="sortTable(2)">
                                Marca <i class="fas fa-sort ml-1"></i>
                            </th>
                            <th class="px-4 py-3 text-left">Descripción</th>
                            <th class="px-4 py-3 text-left">Número de Serie</th>
                            <th class="px-4 py-3 text-left cursor-pointer hover:text-accent" onclick="sortTable(5)">
                                Estado <i class="fas fa-sort ml-1"></i>
                            </th>
                            <th class="px-4 py-3 text-left cursor-pointer hover:text-accent" onclick="sortTable(6)">
                                Ubicación <i class="fas fa-sort ml-1"></i>
                            </th>
                            <th class="px-4 py-3 text-center">Acciones</th>
                            <th class="px-4 py-3 text-left cursor-pointer hover:text-accent" onclick="sortTable(8)">
                                Fecha de Ingreso <i class="fas fa-sort ml-1"></i>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($articulos as $articulo)
                        <tr class="border-t border-gray-200 hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 whitespace-nowrap">{{ $articulo->id }}</td>
                            <td class="px-4 py-3 font-medium">{{ $articulo->modelo->nombre }}</td>
                            <td class="px-4 py-3">{{ $articulo->modelo->marca->nombre ?? 'Sin marca' }}</td>
                            <td class="px-4 py-3 max-w-xs truncate">{{ $articulo->modelo->descripcion ?? 'Sin descripción' }}</td>
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
                            <td class="px-4 py-3">{{ $articulo->ubicacion->nombre ?? 'No asignada' }}</td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center items-center space-x-2">
                                    <a href="{{ route('articulos.edit', $articulo) }}" class="bg-blue-500 hover:bg-blue-600 text-white p-2 rounded transition">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button 
                                        type="button" 
                                        onclick="showDeleteModal({{ $articulo->id }}, '{{ $articulo->modelo->nombre }} - {{ $articulo->numero_serie }}')" 
                                        class="bg-red-500 hover:bg-red-600 text-white p-2 rounded transition">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                            <td class="px-4 py-3">{{ $articulo->fecha_ingreso ?? 'No registrada' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Empty State (cuando no hay artículos) -->
            @if(count($articulos) == 0)
            <div class="text-center py-16">
                <i class="fas fa-boxes text-gray-300 text-5xl mb-4"></i>
                <h3 class="text-xl font-medium text-gray-600">No hay artículos registrados</h3>
                <p class="text-gray-500 mt-2">Comienza agregando un nuevo artículo para gestionar tu inventario</p>
                <a href="{{ route('articulos.create') }}" class="mt-4 inline-block bg-accent hover:bg-green-600 text-white font-medium py-2 px-6 rounded-lg transition">
                    <i class="fas fa-plus mr-2"></i> Agregar artículo
                </a>
                
            </div>
            @endif
            
            <!-- Pagination -->
            <div class="border-t border-gray-200 px-6 py-4 flex items-center justify-between">
                <div class="text-sm text-gray-600">
                    Mostrando <span class="font-medium">{{ count($articulos) }}</span> artículos
                </div>
                <!-- Si tienes paginación de Laravel, puedes usarla aquí -->
                
                <!-- O bien, una paginación simulada -->
                <div class="flex space-x-1">
                    <button class="px-3 py-1 bg-gray-200 text-gray-700 rounded-l hover:bg-gray-300 transition">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="px-3 py-1 bg-primary text-white rounded">1</button>
                    <button class="px-3 py-1 bg-gray-200 text-gray-700 rounded-r hover:bg-gray-300 transition">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md mx-4">
            <div class="text-center mb-6">
                <div class="bg-red-100 rounded-full p-3 inline-flex">
                    <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mt-4">Confirmar eliminación</h3>
                <p class="text-gray-600 mt-2">¿Estás seguro que deseas eliminar el artículo <strong id="articuloName"></strong>? Esta acción no se puede deshacer.</p>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                    Cancelar
                </button>
                <form id="deleteForm" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                        Sí, eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Toggle mobile menu
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
        
        // Delete modal functionality
        function showDeleteModal(id, name) {
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('articuloName').textContent = name;
            document.getElementById('deleteForm').action = `/articulos/${id}`;
        }
        
        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
        
        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            filterArticulos();
        });
        
        // Estado filter functionality
        document.getElementById('estadoFilter').addEventListener('change', function() {
            filterArticulos();
        });
        
        function filterArticulos() {
            const searchValue = document.getElementById('searchInput').value.toLowerCase();
            const estadoValue = document.getElementById('estadoFilter').value;
            
            const table = document.getElementById('articulosTable');
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
            
            for (let i = 0; i < rows.length; i++) {
                const modelo = rows[i].getElementsByTagName('td')[1].textContent.toLowerCase();
                const marca = rows[i].getElementsByTagName('td')[2].textContent.toLowerCase();
                const serie = rows[i].getElementsByTagName('td')[4].textContent.toLowerCase();
                const estado = rows[i].getElementsByTagName('td')[5].textContent.trim();
                
                const matchesSearch = modelo.includes(searchValue) || 
                                    marca.includes(searchValue) || 
                                    serie.includes(searchValue);
                                    
                const matchesEstado = estadoValue === '' || estado === estadoValue;
                
                if (matchesSearch && matchesEstado) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        }
        
        // Table sorting
        let sortDirection = 1; // 1 for ascending, -1 for descending
        
        function sortTable(columnIndex) {
            const table = document.getElementById('articulosTable');
            const tbody = table.getElementsByTagName('tbody')[0];
            const rows = Array.from(tbody.getElementsByTagName('tr'));
            
            // Toggle sort direction
            sortDirection = -sortDirection;
            
            // Sort rows
            rows.sort((a, b) => {
                const cellA = a.getElementsByTagName('td')[columnIndex].textContent.trim();
                const cellB = b.getElementsByTagName('td')[columnIndex].textContent.trim();
                
                if (cellA < cellB) {
                    return -1 * sortDirection;
                } else if (cellA > cellB) {
                    return 1 * sortDirection;
                } else {
                    return 0;
                }
            });
            
            // Reorder table
            for (const row of rows) {
                tbody.appendChild(row);
            }
        }
        
        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            const modal = document.getElementById('deleteModal');
            if (event.target === modal) {
                closeDeleteModal();
            }
        });
    </script>
</body>
</html>