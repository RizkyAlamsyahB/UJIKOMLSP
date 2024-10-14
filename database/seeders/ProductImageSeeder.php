<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductImageSeeder extends Seeder
{
    public function run()
    {
        $products = DB::table('products')->get(); // Dapatkan semua produk
        $images = [
            'alat-bantu-dengar.jpeg',
            'alat-bantu-jalan.webp',
            'alat-pengukur-tekanan-darah.webp',
            'alat-pijat-elektrik.webp',
            'kursi-medis.jpeg',
            'kursi-roda.webp',
            'perban-medis.webp',
            'stetoskop.webp',
            'termometer.webp'
        ];

        foreach ($products as $index => $product) {
            DB::table('product_images')->insert([
                'id' => Str::uuid(),
                'product_id' => $product->id,
                'image_path' => 'images/products/' . $images[$index],
                'is_primary' => true,
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

}

