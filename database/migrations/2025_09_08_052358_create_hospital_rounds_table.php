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
                Schema::create('hospital_rounds', function (Blueprint $table) {
                    $table->id();
                    $table->foreignId('user_id')->constrained('users'); // Usuario que hace la ronda
                    $table->foreignId('servicio_id')->constrained('servicios'); // Servicio/área revisada
                    $table->boolean('falla_encontrada')->default(false);
                    $table->text('observaciones')->nullable();
                    $table->string('responsable_servicio_nombre'); // Nombre de la enfermera jefe o responsable del área
                    $table->text('responsable_servicio_firma_url')->nullable(); // Path a la imagen de la firma
                    $table->timestamps();
                });
            }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospital_rounds');
    }
};
