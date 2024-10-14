<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['id' => Str::uuid(), 'name' => 'Kursi Roda', 'slug' => Str::slug('Kursi Roda')],
            ['id' => Str::uuid(), 'name' => 'Alat Ukur Tekanan Darah', 'slug' => Str::slug('Alat Ukur Tekanan Darah')],
            ['id' => Str::uuid(), 'name' => 'Alat Pemantau Gula Darah', 'slug' => Str::slug('Alat Pemantau Gula Darah')],
            ['id' => Str::uuid(), 'name' => 'Masker Medis', 'slug' => Str::slug('Masker Medis')],
            ['id' => Str::uuid(), 'name' => 'Alat Bantu Dengar', 'slug' => Str::slug('Alat Bantu Dengar')],
            ['id' => Str::uuid(), 'name' => 'Alat Rehabilitasi', 'slug' => Str::slug('Alat Rehabilitasi')],
            ['id' => Str::uuid(), 'name' => 'Kursi Mandi', 'slug' => Str::slug('Kursi Mandi')],
            ['id' => Str::uuid(), 'name' => 'Tongkat Bantu', 'slug' => Str::slug('Tongkat Bantu')],
            ['id' => Str::uuid(), 'name' => 'Alat Pijat', 'slug' => Str::slug('Alat Pijat')],
            ['id' => Str::uuid(), 'name' => 'Perban dan Pembalut', 'slug' => Str::slug('Perban dan Pembalut')],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert($category);
        }
    }

}
