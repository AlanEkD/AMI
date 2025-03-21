<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-primary leading-tight flex items-center">
                <i class="fas fa-user-circle mr-3"></i> 
                Panel de Usuario
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Profile Overview -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 flex items-center">
                    <div class="mr-6">
                        <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center overflow-hidden">
                            @if(Auth::user()->avatar)
                                <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                            @else
                                <i class="fas fa-user text-4xl text-gray-500"></i>
                            @endif
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-primary">{{ Auth::user()->name }}</h3>
                        <p class="text-gray-600">{{ Auth::user()->email }}</p>
                        <div class="mt-2">
                            <span class="bg-accent text-white text-xs px-2 py-1 rounded">
                                Miembro desde {{ Auth::user()->created_at->format('M Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('profile.edit') }}" class="bg-white overflow-hidden shadow-lg sm:rounded-lg hover:shadow-xl transition">
                    <div class="p-6 flex items-center">
                        <div class="bg-blue-100 text-blue-500 p-3 rounded-full mr-4">
                            <i class="fas fa-user-edit text-2xl"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-primary">Editar Perfil</h4>
                            <p class="text-sm text-gray-600">Actualiza tu información personal</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('password.update') }}" class="bg-white overflow-hidden shadow-lg sm:rounded-lg hover:shadow-xl transition">
                    <div class="p-6 flex items-center">
                        <div class="bg-green-100 text-green-500 p-3 rounded-full mr-4">
                            <i class="fas fa-lock text-2xl"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-primary">Cambiar Contraseña</h4>
                            <p class="text-sm text-gray-600">Mantén tu cuenta segura</p>
                        </div>
                    </div>
                </a>

                <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                    <div class="p-6 flex items-center">
                        <div class="bg-red-100 text-red-500 p-3 rounded-full mr-4">
                            <i class="fas fa-sign-out-alt text-2xl"></i>
                        </div>
                        <div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-left w-full">
                                    <h4 class="text-lg font-semibold text-primary">Cerrar Sesión</h4>
                                    <p class="text-sm text-gray-600">Salir de tu cuenta</p>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Stats (Placeholder - customize as needed) -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-primary mb-4">
                        <i class="fas fa-chart-bar mr-2"></i> Estadísticas de Cuenta
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="text-sm text-gray-600">Último Inicio de Sesión</h4>
                            <p class="font-bold text-primary">
                                {{ Auth::user()->last_login_at ? Auth::user()->last_login_at->diffForHumans() : 'No disponible' }}
                            </p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <h4 class="text-sm text-gray-600">Sesiones Activas</h4>
                            <p class="font-bold text-primary">1</p>
                        </div>
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <h4 class="text-sm text-gray-600">Acceso más reciente</h4>
                            <p class="font-bold text-primary">
                                {{ Auth::user()->updated_at->diffForHumans() }}
                            </p>
                        </div>
                        <div class="bg-red-50 p-4 rounded-lg">
                            <h4 class="text-sm text-gray-600">Cambio de Contraseña</h4>
                            <p class="font-bold text-primary">
                                {{ Auth::user()->password_changed_at ? Auth::user()->password_changed_at->diffForHumans() : 'Nunca' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>