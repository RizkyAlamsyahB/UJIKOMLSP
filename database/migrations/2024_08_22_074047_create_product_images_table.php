<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_images', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('product_id'); // Foreign Key ke tabel products
            $table->string('image_path', 255); // Path gambar di storage
            $table->boolean('is_primary')->default(false); // Menandakan apakah ini gambar utama atau tidak
            $table->integer('order')->default(0); // Urutan tampilan gambar

            // Timestamps dan Soft Deletes
            $table->timestamps();
            $table->softDeletes();

            // Menambahkan foreign key constraint
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
