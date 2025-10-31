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
                Schema::table('defibrillator_tests', function (Blueprint $table) {
                    $table->text('responsable_servicio_firma_url')->nullable()->after('responsable_servicio_nombre');
                });
            }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('defibrillator_tests', function (Blueprint $table) {
            //
        });
    }
};
