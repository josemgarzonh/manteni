<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssetTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('asset_types')->insert([
            ['nombre' => 'Equipo Biomédico'],
            ['nombre' => 'Equipo de Cómputo'],
            ['nombre' => 'Equipo Industrial'],
            ['nombre' => 'Vehículo'],
            ['nombre' => 'Infraestructura'],
        ]);
    }
}