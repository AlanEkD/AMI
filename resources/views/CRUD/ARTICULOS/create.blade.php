<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Artículo | AMI</title>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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

    <!-- Breadcrumb -->
    <div class="bg-gray-50 border-b">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center text-sm text-gray-600">
                <a href="#" class="hover:text-primary">Inicio</a>
                <span class="mx-2"><i class="fas fa-chevron-right text-xs"></i></span>
                <a href="{{ route('articulos.index') }}" class="hover:text-primary">Artículos</a>
                <span class="mx-2"><i class="fas fa-chevron-right text-xs"></i></span>
                <span class="text-gray-800 font-medium">Agregar</span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex justify-center items-center p-6">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center">Agregar Artículo</h2>

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

            <form action="{{ route('articulos.store') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Modelo (Input con autocompletado y botón de búsqueda) -->
                <label class="block">
                    <span class="text-gray-700">Modelo:</span>
                    <div class="flex items-center space-x-2">
                        <input type="text" name="modelo_nombre" id="modelo_input"
                            list="modelos" placeholder="Escribe o selecciona un modelo"
                            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                        <button type="button" id="buscar_modelo"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <datalist id="modelos">
                        @foreach ($modelos as $modelo)
                            <option value="{{ $modelo->nombre }}" data-marca="{{ $modelo->marca->id ?? '' }}">
                                {{ $modelo->nombre }}
                            </option>
                        @endforeach
                    </datalist>
                </label>

                <!-- Marca (Dropdown que se autocompleta si el modelo ya existe) -->
                <label class="block">
                    <span class="text-gray-700">Marca:</span>
                    <select name="marca_id" id="marca_select" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                        <option value="">Selecciona una marca</option>
                        @foreach ($marcas as $marca)
                            <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
                        @endforeach
                    </select>
                </label>

                <!-- Número de Serie -->
                <label class="block">
                    <span class="text-gray-700">Número de Serie (Opcional):</span>
                    <input type="text" name="numero_serie" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                </label>

                <!-- Estado -->
                <label class="block">
                    <span class="text-gray-700">Estado:</span>
                    <select name="estado" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                        <option value="Disponible">Disponible</option>
                        <option value="Asignado">Asignado</option>
                        <option value="En reparación">En reparación</option>
                        <option value="Baja">Baja</option>
                    </select>
                </label>

                <!-- Ubicación -->
                <label class="block">
                    <span class="text-gray-700">Ubicación (Opcional):</span>
                    <select name="ubicacion_id" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                        <option value="">Sin ubicación</option>
                        @foreach ($ubicaciones as $ubicacion)
                            <option value="{{ $ubicacion->id }}">{{ $ubicacion->nombre }}</option>
                        @endforeach
                    </select>
                </label>

                <!-- Fecha de Ingreso -->
                <label class="block">
                    <span class="text-gray-700">Fecha de Ingreso:</span>
                    <input type="date" name="fecha_ingreso" value="{{ date('Y-m-d') }}" required class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                </label>

                <!-- Botones -->
                <div class="flex justify-between pt-4">
                    <a href="{{ route('articulos.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Cancelar
                    </a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Script para autocompletar marca al elegir un modelo y búsqueda -->
    <script>
        $(document).ready(function() {
            $('#modelo_input').on('input', function() {
                let inputValue = $(this).val();
                let selectedOption = $("#modelos option").filter(function() {
                    return $(this).val() === inputValue;
                });

                if (selectedOption.length > 0) {
                    let marcaId = selectedOption.data('marca');
                    if (marcaId) {
                        $('#marca_select').val(marcaId);
                    }
                } else {
                    $('#marca_select').val('');
                }
            });

            // Botón de búsqueda de modelo
            $('#buscar_modelo').on('click', function() {
                let modeloBuscado = $('#modelo_input').val();
                if (modeloBuscado === '') {
                    alert('Escribe un modelo para buscar.');
                    return;
                }
                let encontrado = $("#modelos option").filter(function() {
                    return $(this).val().toLowerCase() === modeloBuscado.toLowerCase();
                });

                if (encontrado.length > 0) {
                    let marcaId = encontrado.data('marca');
                    if (marcaId) {
                        $('#marca_select').val(marcaId);
                    }
                    alert('Modelo encontrado: ' + modeloBuscado);
                } else {
                    alert('Modelo no encontrado. Puedes agregarlo manualmente.');
                }
            });
        });

        // Toggle mobile menu
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>
</body>
</html>