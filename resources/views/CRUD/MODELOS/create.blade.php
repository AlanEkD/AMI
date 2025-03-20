<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Modelo | AMI</title>
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
            <a href="#" class="block py-2 hover:text-accent transition">Marcas</a>
            <a href="#" class="block py-2 hover:text-accent transition font-medium">Modelos</a>
            <a href="#" class="block py-2 hover:text-accent transition">Contacto</a>
        </div>
    </nav>

    <!-- Breadcrumb -->
    <div class="bg-gray-50 border-b">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center text-sm text-gray-600">
                <a href="#" class="hover:text-primary">Inicio</a>
                <span class="mx-2"><i class="fas fa-chevron-right text-xs"></i></span>
                <a href="{{ route('modelos.index') }}" class="hover:text-primary">Modelos</a>
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
                <div class="bg-primary text-white px-6 py-4 flex items-center">
                    <i class="fas fa-plus-circle text-xl mr-3"></i>
                    <h2 class="text-xl font-bold">Crear Modelo</h2>
                </div>
                
                <!-- Form Content -->
                <div class="p-6">
                    @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                            <div>
                                <p class="text-red-800 font-medium">Por favor corrige los siguientes errores:</p>
                                <ul class="mt-1 text-red-700 list-disc list-inside text-sm">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif

                    <form action="{{ route('modelos.store') }}" method="POST" id="modeloForm" class="space-y-6">
                        @csrf

                        <div class="form-group">
                            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Modelo <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                                    <i class="fas fa-tag"></i>
                                </span>
                                <input 
                                    type="text" 
                                    id="nombre" 
                                    name="nombre" 
                                    value="{{ old('nombre') }}" 
                                    required 
                                    class="pl-10 w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent @error('nombre') border-red-500 @enderror"
                                    placeholder="Ingrese el nombre del modelo"
                                >
                            </div>
                            @error('nombre')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                            <div class="relative">
                                <textarea 
                                    id="descripcion" 
                                    name="descripcion" 
                                    rows="3" 
                                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent @error('descripcion') border-red-500 @enderror"
                                    placeholder="Ingrese una descripción del modelo"
                                >{{ old('descripcion') }}</textarea>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">
                                <i class="fas fa-info-circle mr-1"></i> Información adicional sobre el modelo (opcional)
                            </p>
                            @error('descripcion')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="marca_id" class="block text-sm font-medium text-gray-700 mb-1">Marca <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                                    <i class="fas fa-building"></i>
                                </span>
                                <select 
                                    id="marca_id" 
                                    name="marca_id" 
                                    required 
                                    class="pl-10 w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent appearance-none @error('marca_id') border-red-500 @enderror"
                                >
                                    <option value="">Seleccione una marca</option>
                                    @foreach ($marcas as $marca)
                                        <option value="{{ $marca->id }}" {{ old('marca_id') == $marca->id ? 'selected' : '' }}>
                                            {{ $marca->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 pointer-events-none">
                                    <i class="fas fa-chevron-down"></i>
                                </span>
                            </div>
                            @error('marca_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row sm:justify-between gap-3 pt-4 border-t">
                            <a href="{{ route('modelos.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 px-4 rounded-lg transition flex items-center justify-center">
                                <i class="fas fa-arrow-left mr-2"></i> Volver al listado
                            </a>
                            <div class="flex gap-3">
                                <button type="reset" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition flex items-center justify-center">
                                    <i class="fas fa-undo mr-2"></i> Restablecer
                                </button>
                                <button type="submit" class="bg-accent hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg transition flex items-center justify-center">
                                    <i class="fas fa-save mr-2"></i> Guardar Modelo
                                </button>
                            </div>
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
        
        // Form validation enhancement
        document.getElementById('modeloForm').addEventListener('submit', function(event) {
            let isValid = true;
            const nombre = document.getElementById('nombre');
            const marca = document.getElementById('marca_id');
            
            // Simple validation
            if (!nombre.value.trim()) {
                isValid = false;
                nombre.classList.add('border-red-500');
            } else {
                nombre.classList.remove('border-red-500');
            }
            
            if (!marca.value) {
                isValid = false;
                marca.classList.add('border-red-500');
            } else {
                marca.classList.remove('border-red-500');
            }
            
            if (!isValid) {
                event.preventDefault();
                // Scroll to the first error
                window.scrollTo({top: 0, behavior: 'smooth'});
                
                // Create alert if it doesn't exist
                if (!document.querySelector('.validation-alert')) {
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'bg-red-50 border-l-4 border-red-500 p-4 mb-6 validation-alert';
                    alertDiv.innerHTML = `
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                            <div>
                                <p class="text-red-800 font-medium">Por favor complete todos los campos requeridos.</p>
                            </div>
                        </div>
                    `;
                    
                    const form = document.getElementById('modeloForm');
                    form.parentNode.insertBefore(alertDiv, form);
                }
            }
        });
        
        // Real-time validation feedback
        const inputs = document.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (this.hasAttribute('required') && !this.value) {
                    this.classList.add('border-red-500');
                } else {
                    this.classList.remove('border-red-500');
                }
            });
        });
    </script>
</body>
</html>