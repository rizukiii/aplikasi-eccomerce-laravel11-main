<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\ProductImages;

class ProductImagesTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Ambil semua ID produk yang ada di tabel products
        $productsIds = \App\Models\Products::all()->pluck('id')->toArray();

        foreach (range(1, 50) as $index) {
            ProductImages::create([
                'products_id' => $faker->randomElement($productsIds), // Ambil ID produk acak
                'photo' => $faker->imageUrl(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

