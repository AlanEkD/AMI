<x-guest-layout>
    <div class="text-center mb-6">
        <div class="bg-blue-100 rounded-full p-3 inline-flex mb-4">
            <i class="fas fa-envelope-open-text text-blue-600 text-2xl"></i>
        </div>
        <h2 class="text-xl font-bold text-gray-800 mb-4">Verifica tu Correo Electrónico</h2>
        <p class="text-sm text-gray-600 mb-4">
            ¡Gracias por registrarte! Antes de comenzar, verifica tu dirección de correo electrónico haciendo clic en el enlace que enviamos a tu email. 
            Si no recibiste el correo, haremos gustosos el reenvío.
        </p>
    </div>
    
    @if (session('status') == 'verification-link-sent')
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700">
                        Se ha enviado un nuevo enlace de verificación a la dirección de correo electrónico que proporcionaste durante el registro.
                    </p>
                </div>
            </div>
        </div>
    @endif
    
    <div class="space-y-4">
        <form method="POST" action="{{ route('verification.send') }}" class="mb-4">
            @csrf
            <button 
                type="submit" 
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent"
            >
                <i class="fas fa-paper-plane mr-2"></i> Reenviar Correo de Verificación
            </button>
        </form>
    
        <div class="text-center">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button 
                    type="submit" 
                    class="text-sm text-primary hover:text-accent underline focus:outline-none"
                >
                    Cerrar Sesión
                </button>
            </form>
        </div>
    </div>
    
    <div class="mt-6 text-center text-sm text-gray-600">
        <p>
            <i class="fas fa-info-circle mr-1 text-blue-500"></i> 
            Revisa tu bandeja de entrada (y carpeta de spam) para encontrar el correo de verificación.
        </p>
    </div>
</x-guest-layout>
