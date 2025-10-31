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
        Schema::table('biomedical_details', function (Blueprint $table) {
            $table->date('fecha_fabricacion')->nullable()->after('fabricante');
            $table->string('correo_fabricante')->nullable()->after('fecha_fabricacion');
            $table->string('contacto_fabricante')->nullable()->after('correo_fabricante');
            $table->string('forma_adquisicion')->nullable()->after('contacto_fabricante');
            $table->string('proveedor_nombre')->nullable()->after('forma_adquisicion');
            $table->decimal('costo_adquisicion', 15, 2)->nullable()->after('proveedor_nombre');
            $table->string('vida_util')->nullable()->after('costo_adquisicion');
            $table->date('garantia_inicio')->nullable()->after('vida_util');
            $table->date('garantia_fin')->nullable()->after('garantia_inicio');
            $table->text('indicaciones_fabricante')->nullable()->after('peso');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('biomedical_details', function (Blueprint $table) {
            $table->dropColumn([
                'fecha_fabricacion', 'correo_fabricante', 'contacto_fabricante', 'forma_adquisicion',
                'proveedor_nombre', 'costo_adquisicion', 'vida_util', 'garantia_inicio', 'garantia_fin',
                'indicaciones_fabricante'
            ]);
        });
    }
};
