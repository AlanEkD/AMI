<x-guest-layout>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf
    
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
                    autofocus 
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
                    autocomplete="current-password"
                    class="pl-10 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-accent focus:border-accent"
                    placeholder="••••••••"
                >
            </div>
            @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    
        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input 
                    id="remember_me" 
                    type="checkbox" 
                    name="remember" 
                    class="h-4 w-4 text-accent focus:ring-accent border-gray-300 rounded"
                >
                <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                    Recordarme
                </label>
            </div>
    
            @if (Route::has('password.request'))
                <div>
                    <a href="{{ route('password.request') }}" class="text-sm text-primary hover:text-accent">
                        ¿Olvidaste tu contraseña?
                    </a>
                </div>
            @endif
        </div>
    
        <div>
            <button 
                type="submit" 
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent"
            >
                Iniciar Sesión
            </button>
        </div>
    
        @if (Route::has('register'))
            <div class="text-center mt-4">
                <p class="text-sm text-gray-600">
                    ¿No tienes una cuenta? 
                    <a href="{{ route('register') }}" class="font-medium text-primary hover:text-accent">
                        Regístrate
                    </a>
                </p>
            </div>
        @endif
    </form>
</x-guest-layout>
