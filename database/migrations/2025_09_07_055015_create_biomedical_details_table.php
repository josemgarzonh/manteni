<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
            {
                Schema::create('biomedical_details', function (Blueprint $table) {
                    // Relación 1 a 1 con la tabla assets
                    $table->foreignId('asset_id')->primary()->constrained('assets')->onDelete('cascade');
            
                    // Clasificaciones (usamos ENUM para restringir las opciones)
                    $table->enum('clasificacion_riesgo', ['I', 'IIA', 'IIB', 'III'])->nullable();
                    $table->enum('clasificacion_uso', ['diagnostico', 'tratamiento', 'soporte', 'rehabilitacion', 'prevencion', 'analisis de laboratorio', 'esterilizacion'])->nullable();
                    $table->enum('tecnologia_predominante', ['electrico', 'electronico', 'electromecanico', 'neumatico', 'hidraulico', 'mecanico', 'optico'])->nullable();
            
                    // Información Adicional de Hoja de Vida
                    $table->string('fabricante')->nullable();
                    $table->string('registro_invima')->nullable();
                    $table->text('componentes_accesorios')->nullable();
            
                    // Registro Técnico de Funcionamiento
                    $table->string('rango_voltaje')->nullable();
                    $table->string('rango_corriente')->nullable();
                    $table->string('rango_potencia')->nullable();
                    $table->string('rango_frecuencia')->nullable();
                    $table->string('rango_presion')->nullable();
                    $table->string('rango_temperatura')->nullable();
                    $table->string('rango_humedad')->nullable();
                    $table->string('peso')->nullable();
            
                    $table->timestamps();
                });
            }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biomedical_details');
    }
};
