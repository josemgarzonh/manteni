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
        Schema::create('spare_part_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maintenance_report_id')->constrained('maintenance_reports')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users'); // El técnico que solicita
            $table->foreignId('asset_id')->constrained('assets'); // El equipo para el que se solicita
            $table->string('part_name');
            $table->integer('quantity')->default(1);
            $table->string('photo_url')->nullable();
            $table->enum('status', ['solicitado', 'aprobado', 'rechazado', 'entregado'])->default('solicitado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spare_part_requests');
    }
};

