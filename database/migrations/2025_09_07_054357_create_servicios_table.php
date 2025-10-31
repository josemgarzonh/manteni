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
                Schema::create('servicios', function (Blueprint $table) {
                    $table->id();
            
                    // --- Relación con la tabla sedes ---
                    $table->unsignedBigInteger('sede_id');
                    $table->foreign('sede_id')->references('id')->on('sedes')->onDelete('cascade');
            
                    $table->string('codigo_servicio')->nullable();
                    $table->string('nombre_servicio');
                    $table->string('grupo_servicio')->nullable();
                    $table->timestamps();
                });
            }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicios');
    }
};
