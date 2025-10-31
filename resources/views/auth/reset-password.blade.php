<x-guest-layout>
    <style>
        body {
            background-image: url('https://www.solucioneslm.com/wp-content/uploads/2020/07/equipos-biomedicos.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .reset-password-card {
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }
    </style>

    <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg reset-password-card">
        <div class="flex justify-center mb-6">
            <a href="/">
                <x-application-logo class="w-auto h-20 fill-current text-gray-500" />
            </a>
        </div>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="password" :value="__('Nueva Contraseña')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirmar Nueva Contraseña')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                    type="password"
                                    name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button>
                    {{ __('Restablecer Contraseña') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>