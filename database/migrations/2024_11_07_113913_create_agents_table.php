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
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transpoter_id')->constrained()->onDelete('cascade');
            $table->foreignId('shipment_method_id')->constrained()->onDelete('cascade');
            $table->foreignId('destination_country_id')->constrained()->onDelete('cascade');
            $table->float('from');
            $table->float('to');
            $table->float('cost');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
