<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $brands = [
            ['id' => Str::uuid(), 'name' => 'Onemed', 'slug' => Str::slug('Onemed')],
            ['id' => Str::uuid(), 'name' => 'Medisana', 'slug' => Str::slug('Medisana')],
            ['id' => Str::uuid(), 'name' => 'Boehringer Ingelheim', 'slug' => Str::slug('Boehringer Ingelheim')],
            ['id' => Str::uuid(), 'name' => 'Philips', 'slug' => Str::slug('Philips')],
            ['id' => Str::uuid(), 'name' => 'Omron', 'slug' => Str::slug('Omron')],
            ['id' => Str::uuid(), 'name' => 'Stryker', 'slug' => Str::slug('Stryker')],
            ['id' => Str::uuid(), 'name' => 'Johnson & Johnson', 'slug' => Str::slug('Johnson & Johnson')],
            ['id' => Str::uuid(), 'name' => 'Baxter', 'slug' => Str::slug('Baxter')],
            ['id' => Str::uuid(), 'name' => 'GE Healthcare', 'slug' => Str::slug('GE Healthcare')],
            ['id' => Str::uuid(), 'name' => 'Medtronic', 'slug' => Str::slug('Medtronic')],
        ];


        foreach ($brands as $brand) {
            DB::table('brands')->insert($brand);
        }
    }


}
