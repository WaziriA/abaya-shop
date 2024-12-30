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
            $table->text('description');
            $table->string('brand');
            $table->decimal('price_usd', 10, 2); // Price in USD (default)
            $table->decimal('price_gbp', 10, 2)->nullable(); // Price in GBP
            $table->decimal('price_eur', 10, 2)->nullable(); // Price in EUR
            $table->decimal('price_aed', 10, 2)->nullable(); // Price in AED
            $table->string('sku');
            $table->integer('stock');
            $table->enum('availability_status', ['in-stock', 'out-of-stock', 'low-stock']);
            $table->string('color')->nullable();
            $table->string('size')->nullable();
            $table->integer('view_count')->default(0);
            $table->enum('status', ['new', 'trending', 'sold-out', 'sale', 'hot', 'popular']);
            $table->string('location')->nullable();
            $table->string('image')->nullable();
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
