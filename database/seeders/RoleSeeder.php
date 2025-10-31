<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['nombre_rol' => 'Super Administrador'],
            ['nombre_rol' => 'Gerente'],
            ['nombre_rol' => 'Coordinador Admin'],
            ['nombre_rol' => 'Coordinador de Servicio'],
            ['nombre_rol' => 'Empleado'],
            ['nombre_rol' => 'Técnico'],
            ['nombre_rol' => 'Ingeniero'],
            ['nombre_rol' => 'Visitante'],
        ]);
    }
}