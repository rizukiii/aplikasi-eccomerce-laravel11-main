<?php

namespace Database\Seeders;

use App\Models\Brands;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Brands::insert([
            ['name' => 'Erigo', 'slug' => 'erigo', 'logo' => 'erigo.png'],
            ['name' => '3Second', 'slug' => '3second', 'logo' => '3second.png'],
            ['name' => 'Cottonology', 'slug' => 'cottonology', 'logo' => 'cottonology.png'],
            ['name' => 'Thanksinsomnia', 'slug' => 'thanksinsomnia', 'logo' => 'thanks.png'],
            ['name' => 'M231', 'slug' => 'm231', 'logo' => 'm231.png'],
            ['name' => 'Bloods', 'slug' => 'bloods', 'logo' => 'bloods.png'],
        ]);
    }
}
