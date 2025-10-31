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
        Schema::table('hospital_rounds', function (Blueprint $table) {
            // Estas son las columnas que SÍ faltan
            $table->foreignId('zona_id')->nullable()->constrained('zonas')->after('servicio_id');
            $table->foreignId('asset_id')->nullable()->constrained('assets')->after('zona_id');
            $table->text('failure_description')->nullable()->after('asset_id'); // Descripción específica de la falla
            $table->string('image_url')->nullable()->after('failure_description'); // Para la foto
            $table->foreignId('maintenance_request_id')->nullable()->constrained('maintenance_requests')->after('image_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hospital_rounds', function (Blueprint $table) {
            $table->dropForeign(['zona_id']);
            $table->dropForeign(['asset_id']);
            $table->dropForeign(['maintenance_request_id']);
            $table->dropColumn(['zona_id', 'asset_id', 'failure_description', 'image_url', 'maintenance_request_id']);
        });
    }
};