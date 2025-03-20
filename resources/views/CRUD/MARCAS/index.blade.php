<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Marcas | AMI</title>
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
    <style>
        /* Estilos para la vista previa */
        #logoPreview {
            display: none;
            position: absolute;
            z-index: 10;
            border: 1px solid #ccc;
            background: white;
            padding: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            max-width: 250px;
            min-width: 100px;
            text-align: center;
        }
        
        /* Asegurar que las imágenes de logo tengan un tamaño consistente en la tabla */
        .logo-container {
            width: 100%;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .logo-image {
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
        }
    </style>
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
            <a href="#" class="block py-2 hover:text-accent transition">Artículos</a>
            <a href="#" class="block py-2 hover:text-accent transition font-medium">Marcas</a>
            <a href="#" class="block py-2 hover:text-accent transition">Modelos</a>
            <a href="#" class="block py-2 hover:text-accent transition">Contacto</a>
        </div>
    </nav>

    <!-- Page Header -->
    <div class="bg-primary text-white py-6">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold">Gestión de Marcas</h1>
            <p class="mt-2">Administra las marcas disponibles en el inventario</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Header & Actions -->
            <div class="p-6 border-b border-gray-200 flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center">
                    <i class="fas fa-building text-primary text-xl mr-3"></i>
                    <h2 class="text-2xl font-bold text-primary">Lista de Marcas</h2>
                </div>
                <div class="flex items-center gap-4 w-full md:w-auto">
                    <div class="relative w-full md:w-64">
                        <input 
                            type="text" 
                            id="searchInput" 
                            placeholder="Buscar marca..." 
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent"
                        >
                        <span class="absolute right-3 top-2.5 text-gray-400">
                            <i class="fas fa-search"></i>
                        </span>
                    </div>
                    <a href="{{ route('marcas.create') }}" class="bg-accent hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg transition flex items-center whitespace-nowrap">
                        <i class="fas fa-plus mr-2"></i> Nueva Marca
                    </a>
                </div>
            </div>
            
            <!-- Table Section -->
            <div class="overflow-x-auto">
                <table class="w-full border-collapse" id="marcasTable">
                    <thead>
                        <tr class="bg-gray-50 text-gray-700 text-sm uppercase tracking-wider">
                            <th class="px-6 py-3 text-left">ID</th>
                            <th class="px-6 py-3 text-left cursor-pointer hover:text-accent" onclick="sortTable(1)">
                                Nombre <i class="fas fa-sort ml-1"></i>
                            </th>
                            <th class="px-6 py-3 text-left">Logo</th>
                            <th class="px-6 py-3 text-left">Modelos</th>
                            <th class="px-6 py-3 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($marcas as $marca)
                        <tr class="border-t border-gray-200 hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $marca->id }}</td>
                            <td class="px-6 py-4 font-medium">{{ $marca->nombre }}</td>
                            <td class="px-6 py-4 text-center">
                                @if($marca->logo)
                                    <div class="flex justify-center items-center h-10">
                                        <img 
                                            src="{{ asset($marca->logo) }}" 
                                            alt="{{ $marca->nombre }}"
                                            class="max-h-10 max-w-full object-contain cursor-pointer hover:scale-110 transition transform duration-300"
                                            onmouseover="showPreview(event, '{{ asset($marca->logo) }}')" 
                                            onmouseout="hidePreview()"
                                        >
                                    </div>
                                @else
                                    <span class="text-gray-400"><i class="fas fa-ban"></i> Sin logo</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    {{ $marca->modelos_count ?? 0 }} modelos
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center items-center space-x-2">
                                    <a href="{{ route('marcas.edit', $marca) }}" class="bg-blue-500 hover:bg-blue-600 text-white p-2 rounded transition">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button 
                                        type="button" 
                                        onclick="showDeleteModal({{ $marca->id }}, '{{ $marca->nombre }}')" 
                                        class="bg-red-500 hover:bg-red-600 text-white p-2 rounded transition">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Empty State (cuando no hay marcas) -->
            @if(count($marcas) == 0)
            <div class="text-center py-16">
                <i class="fas fa-building text-gray-300 text-5xl mb-4"></i>
                <h3 class="text-xl font-medium text-gray-600">No hay marcas registradas</h3>
                <p class="text-gray-500 mt-2">Comienza agregando una nueva marca para gestionar tu inventario</p>
                <a href="{{ route('marcas.create') }}" class="mt-4 inline-block bg-accent hover:bg-green-600 text-white font-medium py-2 px-6 rounded-lg transition">
                    <i class="fas fa-plus mr-2"></i> Agregar marca
                </a>
            </div>
            @endif
            
            <!-- Pagination -->
            <div class="border-t border-gray-200 px-6 py-4 flex items-center justify-between">
                <div class="text-sm text-gray-600">
                    Mostrando <span class="font-medium">{{ count($marcas) }}</span> marcas
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
                <p class="text-gray-600 mt-2">¿Estás seguro que deseas eliminar la marca <strong id="marcaName"></strong>? Esta acción no se puede deshacer.</p>
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
    
    <!-- Logo Preview Container -->
    <div id="logoPreview">
        <img id="previewImage" class="h-24 w-auto max-w-xs object-contain mx-auto">
    </div>

    <!-- Scripts -->
    <script>
        // Toggle mobile menu
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
        
        // Logo preview functionality
        function showPreview(event, imageUrl) {
            const preview = document.getElementById('logoPreview');
            const img = document.getElementById('previewImage');
            img.src = imageUrl;
            preview.style.display = 'block';
            preview.style.left = (event.pageX + 10) + 'px';
            preview.style.top = (event.pageY + 10) + 'px';
        }

        function hidePreview() {
            document.getElementById('logoPreview').style.display = 'none';
        }
        
        // Delete modal functionality
        function showDeleteModal(id, name) {
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('marcaName').textContent = name;
            document.getElementById('deleteForm').action = `/marcas/${id}`;
        }
        
        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
        
        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            const table = document.getElementById('marcasTable');
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
            
            for (let i = 0; i < rows.length; i++) {
                const nombre = rows[i].getElementsByTagName('td')[1].textContent.toLowerCase();
                
                if (nombre.includes(searchValue)) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        });
        
        // Table sorting
        let sortDirection = 1; // 1 for ascending, -1 for descending
        
        function sortTable(columnIndex) {
            const table = document.getElementById('marcasTable');
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