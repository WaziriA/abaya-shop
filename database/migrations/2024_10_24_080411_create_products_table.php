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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('description');
            $table->string('brand');
            $table->string('price');
            $table->string('sku');
            $table->integer('stock');
            $table->enum('availability_status', ['in-stock', 'out-of-stock', 'low-stock']);
            $table->string('color');
            $table->string('size');
            $table->integer('view_count')->default(0);
            $table->enum('status', ['new', 'trending', 'sold-out', 'sale', 'hot', 'pupular']);
            $table->string('location');
            $table->string('image');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
