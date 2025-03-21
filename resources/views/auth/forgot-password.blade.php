<x-guest-layout>

    <div class="mb-4 text-sm text-gray-600">
        ¿Olvidaste tu contraseña? No hay problema. Solo ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.
    </div>
    
    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
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
                    value="{{ old('email') }}"
                    class="pl-10 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-accent focus:border-accent"
                    placeholder="ejemplo@correo.com"
                >
            </div>
            @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    
        <div>
            <button 
                type="submit" 
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent"
            >
                Enviar Enlace de Restablecimiento
            </button>
        </div>
    
        <div class="text-center mt-4">
            <p class="text-sm text-gray-600">
                <a href="{{ route('login') }}" class="font-medium text-primary hover:text-accent">
                    Volver a Iniciar Sesión
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
