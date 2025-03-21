<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        Esta es un área segura de la aplicación. Por favor, confirme su contraseña antes de continuar.
    </div>
    
    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
        @csrf
    
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
                    placeholder="Ingrese su contraseña"
                >
            </div>
            @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    
        <div class="flex justify-end mt-4">
            <button 
                type="submit" 
                class="flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent"
            >
                Confirmar
            </button>
        </div>
    
        <div class="text-center mt-4">
            <p class="text-sm text-gray-600">
                <a href="{{ route('dashboard') }}" class="font-medium text-primary hover:text-accent">
                    Volver al Panel Principal
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
