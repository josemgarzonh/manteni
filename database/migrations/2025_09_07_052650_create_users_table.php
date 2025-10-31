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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('cargo')->nullable();
            $table->string('firma_url')->nullable();
    
            // --- Aquí creamos la relación ---
            $table->unsignedBigInteger('rol_id'); // Columna para guardar el ID del rol
            $table->foreign('rol_id')->references('id')->on('roles')->onDelete('cascade');
            // ---------------------------------
    
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
