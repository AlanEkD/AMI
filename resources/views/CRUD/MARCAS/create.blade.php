<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Marca | AMI</title>
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
            <a href="#" class="block py-2 hover:text-accent transition">Artículos</a>
            <a href="#" class="block py-2 hover:text-accent transition font-medium">Marcas</a>
            <a href="#" class="block py-2 hover:text-accent transition">Modelos</a>
            <a href="#" class="block py-2 hover:text-accent transition">Contacto</a>
        </div>
    </nav>

    <!-- Breadcrumb -->
    <div class="bg-gray-50 border-b">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center text-sm text-gray-600">
                <a href="#" class="hover:text-primary">Inicio</a>
                <span class="mx-2"><i class="fas fa-chevron-right text-xs"></i></span>
                <a href="{{ route('marcas.index') }}" class="hover:text-primary">Marcas</a>
                <span class="mx-2"><i class="fas fa-chevron-right text-xs"></i></span>
                <span class="text-gray-800 font-medium">Crear</span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Form Header -->
                <div class="bg-primary text-white px-6 py-4 flex items-center justify-center">
                    <h2 class="text-2xl font-bold text-center">Agregar Marca</h2>
                </div>
                
                <!-- Form Content -->
                <div class="p-6">
                    <!-- Mostrar errores si existen -->
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 mb-4 rounded">
                            <strong>¡Corrige los siguientes errores!</strong>
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Formulario -->
                    <form action="{{ route('marcas.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf

                        <!-- Nombre de la Marca -->
                        <label class="block">
                            <span class="text-gray-700">Nombre de la Marca:</span>
                            <input 
                                type="text" 
                                name="nombre" 
                                required 
                                value="{{ old('nombre') }}"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            >
                        </label>

                        <!-- Logo de la Marca (Opcional) -->
                        <label class="block">
                            <span class="text-gray-700">Logo (Opcional):</span>
                            <input 
                                type="file" 
                                name="logo" 
                                accept="image/*"
                                class="mt-1 block w-full border border-gray-300 rounded-md"
                            >
                        </label>

                        <!-- Descripción (Opcional) -->
                        <label class="block">
                            <span class="text-gray-700">Descripción (Opcional):</span>
                            <textarea 
                                name="descripcion" 
                                rows="3" 
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            >{{ old('descripcion') }}</textarea>
                        </label>

                        <!-- Botones -->
                        <div class="flex justify-between pt-4">
                            <a href="{{ route('marcas.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Cancelar
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Form Info Card -->
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mt-6 rounded-r-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-500"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Información</h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <p>Los campos marcados con <span class="text-red-500">*</span> son obligatorios.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scripts -->
    <script>
        // Toggle mobile menu
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>
</body>
</html>