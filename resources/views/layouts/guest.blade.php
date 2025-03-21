
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'AMI Inventory') }} - Login</title>
    
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
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-primary text-white px-6 py-4 text-center">
                <div class="flex justify-center mb-4">
                    <div class="bg-gray-200 p-2 rounded-lg">
                        <img src="{{ asset('img/ami logo.png') }}" alt="AMI Logo" class="h-16">
                    </div>
                </div>
                <h2 class="text-2xl font-bold">AMI Inventory</h2>
                <p class="text-sm mt-2">Iniciar Sesión</p>
            </div>
            
            <div class="p-8">
                {{ $slot }}
            </div>
            
            <div class="bg-gray-50 px-8 py-4 text-center text-sm text-gray-600">
                © {{ date('Y') }} AMI Inventory. Todos los derechos reservados.
            </div>
        </div>
    </div>

    <script>
        // Optional: Add any login page specific scripts here
    </script>
</body>
</html>
```