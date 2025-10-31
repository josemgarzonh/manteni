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
                        Schema::table('ips', function (Blueprint $table) {
                            // Hacemos que estas columnas acepten valores nulos (vacíos)
                            $table->string('naturaleza_juridica')->nullable()->change();
                            $table->string('departamento')->nullable()->change();
                            $table->string('municipio')->nullable()->change();
                            $table->string('direccion')->nullable()->change();
                            $table->string('telefono')->nullable()->change();
                            $table->string('email')->nullable()->change();
                            $table->string('razon_social')->nullable()->change();
                            $table->string('representante_legal')->nullable()->change();
                        });
                    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ips', function (Blueprint $table) {
            //
        });
    }
};
