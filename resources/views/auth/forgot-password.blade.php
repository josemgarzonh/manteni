<x-guest-layout>
    <style>
        body {
            background-image: url('https://www.solucioneslm.com/wp-content/uploads/2020/07/equipos-biomedicos.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .forgot-password-card {
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }
    </style>

    <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg forgot-password-card">
        <div class="flex justify-center mb-6">
            <a href="/">
                <x-application-logo class="w-auto h-20 fill-current text-gray-500" />
            </a>
        </div>
        
        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            {{ __('¿Olvidaste tu contraseña? No hay problema. Solo déjanos saber tu dirección de correo electrónico y te enviaremos un enlace para restablecer la contraseña que te permitirá elegir una nueva.') }}
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button>
                    {{ __('Enviar Enlace de Restablecimiento') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>