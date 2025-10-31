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
                    Schema::create('disposal_protocols', function (Blueprint $table) {
                        $table->id();
                        $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
                        $table->foreignId('user_id')->constrained('users'); // Usuario que realizó la evaluación
                
                        // Scores de Evaluación Técnica (T)
                        $table->tinyInteger('T_edad');
                        $table->tinyInteger('T_soporte_refacciones');
                        $table->tinyInteger('T_soporte_consumibles');
                        $table->tinyInteger('T_soporte_tecnico');
                
                        // Scores de Evaluación Clínica (C)
                        $table->tinyInteger('C_facilidad_uso');
                        $table->tinyInteger('C_satisface_necesidades');
                        $table->tinyInteger('C_confianza_resultados');
                        $table->tinyInteger('C_contribuye_practica');
                        $table->tinyInteger('C_tiempo_reparacion_largo');
                        $table->tinyInteger('C_frecuencia_uso_apropiada');
                
                        // Valores de Evaluación Económica (E)
                        $table->decimal('E_costo_mantenimiento', 15, 2);
                        $table->decimal('E_costo_sustitucion', 15, 2);
                
                        // Resultados Calculados
                        $table->decimal('score_V_final', 8, 2);
                        $table->string('recommendation');
                
                        $table->timestamps();
                    });
                }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disposal_protocols');
    }
};
