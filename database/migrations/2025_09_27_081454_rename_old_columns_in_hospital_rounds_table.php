<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hospital_rounds', function (Blueprint $table) {
            $table->renameColumn('falla_encontrada', 'found_failures');
            $table->renameColumn('observaciones', 'observations');
            $table->renameColumn('responsable_servicio_nombre', 'responsible_name');
            $table->renameColumn('responsable_servicio_firma_url', 'responsible_signature');
        });
    }

    public function down(): void
    {
        Schema::table('hospital_rounds', function (Blueprint $table) {
            $table->renameColumn('found_failures', 'falla_encontrada');
            $table->renameColumn('observations', 'observaciones');
            $table->renameColumn('responsible_name', 'responsable_servicio_nombre');
            $table->renameColumn('responsible_signature', 'responsable_servicio_firma_url');
        });
    }
};