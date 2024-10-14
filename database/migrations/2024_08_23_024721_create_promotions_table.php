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
        Schema::create('promotions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('image_path'); // Menyimpan path atau URL gambar
            $table->string('description')->nullable(); // Deskripsi promosi
            $table->date('start_date'); // Tanggal mulai promosi
            $table->date('end_date'); // Tanggal berakhir promosi
            $table->boolean('status')->default(true); // Status aktif/tidak aktif
            $table->timestamps(); // Kolom waktu untuk created_at dan updated_at
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
