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
        Schema::table('spare_part_requests', function (Blueprint $table) {
            // Hacemos que la columna acepte valores nulos (null)
            $table->foreignId('maintenance_report_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spare_part_requests', function (Blueprint $table) {
            // Revertimos el cambio si es necesario
            $table->foreignId('maintenance_report_id')->nullable(false)->change();
        });
    }
};