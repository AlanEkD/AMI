<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'AMI Inventory') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Tailwind CSS -->
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

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-gray-100">
        <div class="min-h-screen">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset
            
            <!-- Page Content -->
            <main class="container mx-auto px-4 py-6">
                {{ $slot }}
            </main>
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
                        <p class="text-sm">© {{ date('Y') }} AMI Inventory. Todos los derechos reservados.</p>
                    </div>
                    <div class="flex space-x-4">
                        <a href="#" class="text-white hover:text-accent transition">Términos</a>
                        <a href="#" class="text-white hover:text-accent transition">Privacidad</a>
                        <a href="#" class="text-white hover:text-accent transition">Contacto</a>
                    </div>
                </div>
            </div>
        </footer>

        @livewireScripts

        <script>
            // Optional: Add any global scripts or functionality here
            document.addEventListener('DOMContentLoaded', function() {
                // Mobile menu toggle (if needed)
                const mobileMenuButton = document.getElementById('mobile-menu-button');
                const mobileMenu = document.getElementById('mobile-menu');
                
                if (mobileMenuButton && mobileMenu) {
                    mobileMenuButton.addEventListener('click', function() {
                        mobileMenu.classList.toggle('hidden');
                    });
                }
            });
        </script>
    </body>
</html>