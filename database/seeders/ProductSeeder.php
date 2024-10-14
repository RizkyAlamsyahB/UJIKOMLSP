<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Misalkan Anda mendapatkan UUID dari kategori dan brand
        $categoryId = '5f85c1b1-68e1-4a0f-978a-e8fe267ce161'; // UUID kategori
        $brandId = '4249df7b-03fa-4fdb-8607-59ffefa7f258'; // UUID brand

        // Nama dan deskripsi produk sesuai gambar
        $products = [
            'Alat Bantu Dengar' => 'alat-bantu-dengar.jpeg',
            'Alat Bantu Jalan' => 'alat-bantu-jalan.webp',
            'Alat Pengukur Tekanan Darah' => 'alat-pengukur-tekanan-darah.webp',
            'Alat Pijat Elektrik' => 'alat-pijat-elektrik.webp',
            'Kursi Medis' => 'kursi-medis.jpeg',
            'Kursi Roda' => 'kursi-roda.webp',
            'Perban Medis' => 'perban-medis.webp',
            'Stetoskop' => 'stetoskop.webp',
            'Termometer' => 'termometer.webp'
        ];

        foreach ($products as $name => $image) {
            DB::table('products')->insert([
                'id' => Str::uuid(),
                'name' => $name,
                'description' => $name . ' berkualitas tinggi.',
                'price' => rand(500000, 5000000),
                'stock_quantity' => rand(1, 100),
                'category_id' => $categoryId,
                'brand_id' => $brandId,
                'weight' => rand(1, 20),
                'dimensions' => rand(100, 200) . 'x' . rand(50, 100) . 'x' . rand(50, 100) . ' cm',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

}
