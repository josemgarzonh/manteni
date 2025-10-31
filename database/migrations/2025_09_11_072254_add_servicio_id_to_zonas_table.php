<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
                {
                    Schema::table('zonas', function (Blueprint $table) {
                        // Añadir la columna para el servicio, puede ser nula.
                        $table->foreignId('servicio_id')->nullable()->constrained('servicios')->after('sede_id');
                    });
                }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('zonas', function (Blueprint $table) {
            //
        });
    }
};
