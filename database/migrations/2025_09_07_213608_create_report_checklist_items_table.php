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
                        Schema::create('report_checklist_items', function (Blueprint $table) {
                            $table->id();
                            $table->foreignId('maintenance_report_id')->constrained('maintenance_reports')->onDelete('cascade');
                            $table->string('item_nombre');
                            $table->enum('estado', ['si', 'no', 'na']);
                            $table->timestamps();
                        });
                    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_checklist_items');
    }
};
