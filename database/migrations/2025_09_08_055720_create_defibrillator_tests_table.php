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
                        Schema::create('defibrillator_tests', function (Blueprint $table) {
                            $table->id();
                            $table->foreignId('asset_id')->constrained('assets');
                            $table->foreignId('user_id')->constrained('users'); // Usuario que realiza el test
                            $table->foreignId('servicio_id')->constrained('servicios');
                    
                            // Criterios del Test (basados en el PDF)
                            $table->boolean('criterio_1_estado_externo');
                            $table->boolean('criterio_2_limpieza_palas');
                            $table->boolean('criterio_3_nivel_bateria');
                            $table->boolean('criterio_4_papel_registrador');
                            $table->boolean('criterio_5_test_descarga');
                    
                            $table->text('observaciones')->nullable();
                            $table->string('responsable_servicio_nombre');
                            $table->timestamps();
                        });
                    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('defibrillator_tests');
    }
};
