<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brands;
use Faker\Factory as Faker;

class BrandsTableSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            $name = $faker->unique()->company;
            Brands::create([
                'name' => $name,
                'logo' => $faker->imageUrl(200, 200, 'business', true, $name),
            ]);
        }
    }
}
