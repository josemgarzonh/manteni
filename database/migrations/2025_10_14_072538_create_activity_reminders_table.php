<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('activity_reminders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scheduled_activity_id')->constrained()->onDelete('cascade');
            $table->integer('remind_minutes_before'); // 15, 30, 60, 1440 (24h)
            $table->boolean('sent')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('activity_reminders');
    }
};