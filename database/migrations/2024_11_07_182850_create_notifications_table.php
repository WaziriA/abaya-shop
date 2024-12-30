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
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->morphs('notifiable');
            $table->text('data');
            $table->string('device_type')->nullable(); // Mobile, Tablet, Desktop
            $table->string('os')->nullable();          // Android, iOS, Windows, etc.
            $table->string('browser')->nullable();     // Chrome, Safari, etc.
            $table->string('brand')->nullable();       // Samsung, Apple, etc.
            $table->text('user_agent')->nullable();    // Full User-Agent string
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
