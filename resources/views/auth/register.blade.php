<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf
    
        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nombre Completo</label>
            <div class="mt-1 relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-user text-gray-400"></i>
                </div>
                <input 
                    id="name" 
                    type="text" 
                    name="name" 
                    required 
                    autofocus 
                    autocomplete="name"
                    value="{{ old('name') }}"
                    class="pl-10 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-accent focus:border-accent"
                    placeholder="Nombre y Apellido"
                >
            </div>
            @error('name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    
        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
            <div class="mt-1 relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-envelope text-gray-400"></i>
                </div>
                <input 
                    id="email" 
                    type="email" 
                    name="email" 
                    required 
                    autocomplete="username"
                    value="{{ old('email') }}"
                    class="pl-10 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-accent focus:border-accent"
                    placeholder="ejemplo@correo.com"
                >
            </div>
            @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    
        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
            <div class="mt-1 relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-lock text-gray-400"></i>
                </div>
                <input 
                    id="password" 
                    type="password" 
                    name="password" 
                    required 
                    autocomplete="new-password"
                    class="pl-10 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-accent focus:border-accent"
                    placeholder="••••••••"
                >
            </div>
            @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    
        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Contraseña</label>
            <div class="mt-1 relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-lock text-gray-400"></i>
                </div>
                <input 
                    id="password_confirmation" 
                    type="password" 
                    name="password_confirmation" 
                    required 
                    autocomplete="new-password"
                    class="pl-10 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-accent focus:border-accent"
                    placeholder="••••••••"
                >
            </div>
            @error('password_confirmation')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    
        <div>
            <button 
                type="submit" 
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent"
            >
                Registrarse
            </button>
        </div>
    
        <div class="text-center mt-4">
            <p class="text-sm text-gray-600">
                ¿Ya tienes una cuenta? 
                <a href="{{ route('login') }}" class="font-medium text-primary hover:text-accent">
                    Iniciar Sesión
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
