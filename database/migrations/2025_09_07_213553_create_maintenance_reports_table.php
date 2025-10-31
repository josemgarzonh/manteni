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
                        Schema::create('maintenance_reports', function (Blueprint $table) {
                            $table->id(); // Este será el "REPORTE No"
                            $table->foreignId('asset_id')->constrained('assets');
                            $table->foreignId('tecnico_id')->constrained('users');
                            $table->enum('tipo_mantenimiento', ['preventivo', 'correctivo', 'mejorativo', 'otro']);
                            $table->unsignedInteger('tiempo_ejecucion_horas')->nullable();
                            $table->text('observaciones')->nullable();
                            $table->text('repuestos_utilizados')->nullable();
                            $table->string('recibe_nombre');
                            $table->string('recibe_cargo');
                            $table->text('firma_tecnico_url')->nullable();
                            $table->text('firma_recibe_url')->nullable();
                            $table->timestamps();
                        });
                    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_reports');
    }
};
