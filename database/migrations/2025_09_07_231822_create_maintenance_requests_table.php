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
                Schema::create('maintenance_requests', function (Blueprint $table) {
                    $table->id();
                    $table->foreignId('user_id')->nullable()->constrained('users'); // Quien solicita (si está logueado)
                    $table->foreignId('asset_id')->nullable()->constrained('assets'); // El activo reportado (si se conoce)
            
                    $table->string('solicitante_nombre')->nullable(); // Nombre (si es un invitado)
                    $table->string('ubicacion_texto'); // Descripción de la ubicación
                    $table->text('descripcion'); // Descripción de la falla
                    $table->string('imagen_url')->nullable(); // Para la foto de la falla
            
                    $table->enum('estado', ['Pendiente', 'Asignada', 'En Proceso', 'Finalizada', 'Rechazada'])->default('Pendiente');
            
                    $table->timestamps();
                });
            }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_requests');
    }
};
