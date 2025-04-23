<?php

namespace Database\Seeders;

use App\Models\ProductImages;
use App\Models\ProductSizes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductExtrasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 6; $i++) {
            // Product Images
            ProductImages::create([
                'products_id' => $i,
                'photo' => 'photo_' . $i . '.jpeg',
            ]);

            // Product Sizes
            foreach (['S', 'M', 'L'] as $size) {
                ProductSizes::create([
                    'products_id' => $i,
                    'size' => $size,
                ]);
            }
        }
    }
}
