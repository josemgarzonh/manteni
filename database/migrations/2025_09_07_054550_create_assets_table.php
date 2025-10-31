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
                Schema::create('assets', function (Blueprint $table) {
                    $table->id();
            
                    // --- Relaciones ---
                    $table->foreignId('asset_type_id')->constrained('asset_types');
                    $table->foreignId('sede_id')->constrained('sedes');
                    $table->foreignId('zona_id')->nullable()->constrained('zonas');
                    $table->foreignId('servicio_id')->nullable()->constrained('servicios');
            
                    // --- Datos Comunes del Activo ---
                    $table->string('nombre_equipo');
                    $table->string('marca')->nullable();
                    $table->string('modelo')->nullable();
                    $table->string('serie')->nullable();
                    $table->string('activo_fijo')->nullable()->unique();
                    $table->string('imagen_url')->nullable();
                    $table->date('fecha_adquisicion')->nullable();
                    $table->timestamps();
                });
            }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
