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
                Schema::create('ips', function (Blueprint $table) {
                    $table->id();
                    $table->string('nit', 20)->unique();
                    $table->string('nombre_prestador');
                    $table->string('naturaleza_juridica')->nullable();
                    $table->string('departamento')->nullable();
                    $table->string('municipio')->nullable();
                    $table->string('direccion');
                    $table->string('telefono');
                    $table->string('email')->unique();
                    $table->string('razon_social');
                    $table->string('representante_legal')->nullable();
                    $table->string('logo_url')->nullable();
                    $table->timestamps();
                });
            }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ips');
    }
};
