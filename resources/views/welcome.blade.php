
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Inventario AMI</title>
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
                <a href="#" class="hover:text-accent transition">Contacto</a>
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
            <a href="{{ route('articulos.index') }}" class="block py-2 hover:text-accent transition">Artículos</a>
            <a href="{{ route('marcas.index') }}" class="block py-2 hover:text-accent transition">Marcas</a>
            <a href="{{ route('modelos.index') }}" class="block py-2 hover:text-accent transition">Modelos</a>
            <a href="#" class="block py-2 hover:text-accent transition">Contacto</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-primary text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Sistema de Inventario para AMI</h1>
            <p class="text-xl mb-10">Administra tus artículos, marcas y modelos de manera eficiente y organizada.</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('articulos.index') }}" class="bg-accent hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg transition">
                    <i class="fas fa-boxes mr-2"></i> Gestionar Artículos
                </a>
                <a href="{{ route('marcas.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-lg transition">
                    <i class="fas fa-building mr-2"></i> Gestionar Marcas
                </a>
                <a href="{{ route('modelos.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-lg transition">
                    <i class="fas fa-layer-group mr-2"></i> Gestionar Modelos
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-primary mb-12">Funcionalidades del Sistema</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
                    <div class="text-accent text-center mb-4">
                        <i class="fas fa-boxes text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-primary text-center mb-2">Gestión de Artículos</h3>
                    <p class="text-gray-600 text-center">Agrega, edita y elimina artículos fácilmente con un sistema intuitivo. Asigna estados, ubicaciones y lleva control de tu inventario.</p>
                </div>
                
                <!-- Feature 2 -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
                    <div class="text-accent text-center mb-4">
                        <i class="fas fa-building text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-primary text-center mb-2">Control de Marcas</h3>
                    <p class="text-gray-600 text-center">Administra marcas y sus logos de forma organizada. Visualiza fácilmente todas las marcas disponibles en tu inventario.</p>
                </div>
                
                <!-- Feature 3 -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
                    <div class="text-accent text-center mb-4">
                        <i class="fas fa-layer-group text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-primary text-center mb-2">Gestión de Modelos</h3>
                    <p class="text-gray-600 text-center">Organiza los modelos por marca, añade descripciones detalladas y mantén un catálogo completo de tus productos.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Access Section -->
    <section class="bg-gray-100 py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-primary mb-12">Acceso Rápido</h2>
            <div class="grid md:grid-cols-4 gap-6">
                <a href="{{ route('articulos.create') }}" class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition hover:bg-accent hover:text-white group">
                    <div class="text-center">
                        <i class="fas fa-plus-circle text-2xl mb-2 text-accent group-hover:text-white"></i>
                        <h3 class="text-lg font-bold text-primary group-hover:text-white">Nuevo Artículo</h3>
                    </div>
                </a>
                <a href="{{ route('marcas.create') }}" class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition hover:bg-accent hover:text-white group">
                    <div class="text-center">
                        <i class="fas fa-plus-circle text-2xl mb-2 text-accent group-hover:text-white"></i>
                        <h3 class="text-lg font-bold text-primary group-hover:text-white">Nueva Marca</h3>
                    </div>
                </a>
                <a href="{{ route('modelos.create') }}" class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition hover:bg-accent hover:text-white group">
                    <div class="text-center">
                        <i class="fas fa-plus-circle text-2xl mb-2 text-accent group-hover:text-white"></i>
                        <h3 class="text-lg font-bold text-primary group-hover:text-white">Nuevo Modelo</h3>
                    </div>
                </a>
                <a href="{{ route('articulos.index') }}" class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition hover:bg-accent hover:text-white group">
                    <div class="text-center">
                        <i class="fas fa-list text-2xl mb-2 text-accent group-hover:text-white"></i>
                        <h3 class="text-lg font-bold text-primary group-hover:text-white">Ver Inventario</h3>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Dashboard Preview Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-primary mb-12">Estado del Inventario</h2>
            <div class="bg-gray-200 p-4 rounded-lg shadow-md">
                <div class="bg-white rounded-lg p-6 shadow-inner">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-primary text-white p-4 rounded-lg">
                            <h4 class="font-bold mb-1">Total Artículos</h4>
                            <p class="text-2xl">{{ $totalArticulos ?? 1254 }}</p>
                        </div>
                        <div class="bg-accent text-white p-4 rounded-lg">
                            <h4 class="font-bold mb-1">Marcas Registradas</h4>
                            <p class="text-2xl">{{ $totalMarcas ?? 48 }}</p>
                        </div>
                        <div class="bg-blue-500 text-white p-4 rounded-lg">
                            <h4 class="font-bold mb-1">Modelos Disponibles</h4>
                            <p class="text-2xl">{{ $totalModelos ?? 126 }}</p>
                        </div>
                    </div>
                    
                    <div class="bg-gray-100 rounded-lg p-4">
                        <h4 class="font-bold text-primary mb-2">Estado de Artículos</h4>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                            <div class="bg-green-100 p-4 rounded-lg border-l-4 border-green-500">
                                <h5 class="text-green-700 font-semibold">Disponibles</h5>
                                <p class="text-xl text-green-600">{{ $articulosDisponibles ?? 856 }}</p>
                            </div>
                            <div class="bg-yellow-100 p-4 rounded-lg border-l-4 border-yellow-500">
                                <h5 class="text-yellow-700 font-semibold">Asignados</h5>
                                <p class="text-xl text-yellow-600">{{ $articulosAsignados ?? 324 }}</p>
                            </div>
                            <div class="bg-orange-100 p-4 rounded-lg border-l-4 border-orange-500">
                                <h5 class="text-orange-700 font-semibold">En Reparación</h5>
                                <p class="text-xl text-orange-600">{{ $articulosEnReparacion ?? 42 }}</p>
                            </div>
                            <div class="bg-red-100 p-4 rounded-lg border-l-4 border-red-500">
                                <h5 class="text-red-700 font-semibold">De Baja</h5>
                                <p class="text-xl text-red-600">{{ $articulosBaja ?? 32 }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-primary text-white py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <div class="flex items-center space-x-2">
                        <div class="bg-gray-200 p-2 rounded-lg">
                            <img src="{{ asset('img/ami logo.png') }}" alt="AMI Logo" class="h-10">
                        </div>
                        <span class="text-xl font-bold">AMI Automation</span>
                    </div>
                    <p class="mt-2">© {{ date('Y') }} AMI. Todos los derechos reservados.</p>
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="hover:text-accent transition">Términos</a>
                    <a href="#" class="hover:text-accent transition">Privacidad</a>
                    <a href="#" class="hover:text-accent transition">Contacto</a>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Scripts -->
    <script>
        // Toggle mobile menu
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>
</body>
</html>
```