<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Products;
use App\Models\Brands;
use App\Models\Categories;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Ambil semua ID kategori dan brand yang ada di tabel
        $categoriesIds = Categories::all()->pluck('id')->toArray();
        $brandsIds = Brands::all()->pluck('id')->toArray();

        foreach (range(1, 50) as $index) {
            Products::create([
                'name' => $faker->word,
                'slug' => $faker->slug,
                'thumbnail' => $faker->imageUrl(),
                'about' => $faker->paragraph,
                'price' => $faker->randomFloat(2, 10, 500),
                'categories_id' => $faker->randomElement($categoriesIds), // Pilih kategori acak
                'brands_id' => $faker->randomElement($brandsIds), // Pilih brand acak
                'is_popular' => $faker->boolean,
                'stock' => $faker->numberBetween(10, 100),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}


