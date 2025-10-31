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
                Schema::create('sedes', function (Blueprint $table) {
                    $table->id();
            
                    // --- Relación con la tabla ips ---
                    $table->unsignedBigInteger('ips_id');
                    $table->foreign('ips_id')->references('id')->on('ips')->onDelete('cascade');
            
                    $table->string('nombre_sede');
                    $table->string('zona')->nullable(); // Zona urbana/rural
                    $table->string('direccion');
                    $table->string('telefono')->nullable();
                    $table->string('imagen_url')->nullable();
                    $table->timestamps();
                });
            }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sedes');
    }
};
