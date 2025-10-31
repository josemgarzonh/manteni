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
                    Schema::create('maintenance_schedules', function (Blueprint $table) {
                        $table->id();
                        $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
                        $table->string('task'); // Ej: "Calibración semestral", "Limpieza de filtros"
                        $table->integer('frequency_days'); // Frecuencia en días (ej: 30, 90, 365)
                        $table->date('next_due_date'); // Próxima fecha de mantenimiento
                        $table->enum('status', ['Programado', 'Completado', 'Vencido'])->default('Programado');
                        $table->timestamps();
                    });
                }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_schedules');
    }
};
