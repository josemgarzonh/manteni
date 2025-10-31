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
                    Schema::table('maintenance_requests', function (Blueprint $table) {
                        // Columna para guardar el ID del técnico asignado
                        $table->foreignId('assigned_to')->nullable()->constrained('users')->after('estado');
                    });
                }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('maintenance_requests', function (Blueprint $table) {
            //
        });
    }
};
