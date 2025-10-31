<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buscar el rol de Super Administrador
        $superAdminRole = Role::where('nombre_rol', 'Super Administrador')->first();

        // 2. Si el rol existe, crear el usuario
        if ($superAdminRole) {
            User::firstOrCreate(
                ['email' => 'admin@bioclinik.com'], // Busca por email para no duplicar
                [
                    'name' => 'Administrador General',
                    'password' => Hash::make('password'), // La contraseña será "password"
                    'rol_id' => $superAdminRole->id,
                ]
            );
        }
    }
}