<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->decimal('price', 15, 2);
            $table->unsignedInteger('stock_quantity');
            $table->uuid('category_id')->nullable(); // Foreign Key ke tabel categories
            $table->uuid('brand_id')->nullable(); // Foreign Key ke tabel brands
            $table->decimal('weight', 8, 2)->nullable();
            $table->string('dimensions', 100)->nullable();

            // Timestamps dan Soft Deletes
            $table->timestamps();
            $table->softDeletes();

            // Menambahkan foreign key constraint
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('set null');
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
