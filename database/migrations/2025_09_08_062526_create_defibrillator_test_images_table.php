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
                        Schema::create('defibrillator_test_images', function (Blueprint $table) {
                            $table->id();
                            $table->foreignId('defibrillator_test_id')->constrained('defibrillator_tests')->onDelete('cascade');
                            $table->string('image_url');
                            $table->timestamps();
                        });
                    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('defibrillator_test_images');
    }
};
