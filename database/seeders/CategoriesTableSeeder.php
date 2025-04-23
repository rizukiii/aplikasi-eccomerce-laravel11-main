<?php

namespace Database\Seeders;

use App\Models\Categories;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Categories::insert([
            ['name' => 'Kaos', 'slug' => 'kaos', 'icon' => 'kaos.png'],
            ['name' => 'Kemeja', 'slug' => 'kemeja', 'icon' => 'kemeja.png'],
            ['name' => 'Hoodie', 'slug' => 'hoodie', 'icon' => 'hoodie.png'],
            ['name' => 'Jaket', 'slug' => 'jaket', 'icon' => 'jaket.png'],
            ['name' => 'Sweater', 'slug' => 'sweater', 'icon' => 'sweater.png'],
            ['name' => 'Polo', 'slug' => 'polo', 'icon' => 'polo.png'],
        ]);
    }
}
