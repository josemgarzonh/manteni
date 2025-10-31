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
                Schema::table('assets', function (Blueprint $table) {
                    // Columna para el tipo específico, ej: "Desfibrilador", "Tensiómetro"
                    $table->string('specific_type')->nullable()->after('modelo');
                });
            }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            //
        });
    }
};
