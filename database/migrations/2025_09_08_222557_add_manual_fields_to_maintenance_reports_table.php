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
                        Schema::table('maintenance_reports', function (Blueprint $table) {
                            // Para diferenciar entre reportes automáticos y entradas manuales
                            $table->boolean('is_manual_entry')->default(false)->after('id');
                            // Campo para la fecha de próxima intervención (editable)
                            $table->date('next_intervention_date')->nullable()->after('recibe_cargo');
                            // Hacemos nulables campos que no existen en una entrada manual
                            $table->foreignId('tecnico_id')->nullable()->change();
                            $table->string('recibe_nombre')->nullable()->change();
                            $table->string('recibe_cargo')->nullable()->change();
                            // Campo para el responsable en entradas manuales
                            $table->string('manual_responsable')->nullable()->after('recibe_cargo');
                        });
                    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('maintenance_reports', function (Blueprint $table) {
            //
        });
    }
};
