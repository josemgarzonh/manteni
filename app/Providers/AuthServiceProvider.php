<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Support\Facades\Schema;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Se utiliza un bloque try-catch para evitar errores durante la ejecución de migraciones
        // o comandos de artisan cuando la base de datos aún no está lista.
        try {
            // Usamos Gate::before() para una verificación de permisos centralizada y eficiente.
            Gate::before(function (User $user, string $ability) {
                // Llama al método hasPermission del modelo User.
                // Si ese método devuelve true, la autorización se concede inmediatamente.
                if ($user->hasPermission($ability)) {
                    return true;
                }
            });
        } catch (\Exception $e) {
            // Si ocurre una excepción (p. ej., la tabla de permisos no existe),
            // no registramos las Gates para permitir que el proceso continúe.
            return;
        }
    }
}

