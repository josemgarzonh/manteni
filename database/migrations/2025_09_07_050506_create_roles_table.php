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
            Schema::create('roles', function (Blueprint $table) {
                $table->id(); // Crea una columna 'id' autoincremental (Clave Primaria)
                $table->string('nombre_rol', 50)->unique(); // Crea una columna de texto para el nombre del rol, máximo 50 caracteres y debe ser único
                $table->timestamps(); // Crea las columnas 'created_at' y 'updated_at' automáticamente
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
