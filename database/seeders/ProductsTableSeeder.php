<?php

namespace Database\Seeders;

use App\Models\Products;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // [
            //     'name' => 'Kaos Oversize Erigo',
            //     'price' => 45000,
            //     'thumbnail' => '01JS4GQ4QKZXVWEG0AZMHN7N9H.jpeg',
            //     'about' => 'Kaos oversize nyaman dipakai',
            //     'categories_id' => 1,
            //     'brands_id' => 1,
            //     'is_popular' => true,
            //     'stock' => 45,
            // ],
            // [
            //     'name' => 'Kemeja Flannel 3Second',
            //     'price' => 95000,
            //     'thumbnail' => 'flannel.jpeg',
            //     'about' => 'Kemeja flannel hangat',
            //     'categories_id' => 2,
            //     'brands_id' => 2,
            //     'is_popular' => false,
            //     'stock' => 30,
            // ],
            // [
            //     'name' => 'Hoodie Cowo Thanksinsomnia',
            //     'price' => 125000,
            //     'thumbnail' => 'hoodie.jpeg',
            //     'about' => 'Hoodie kasual',
            //     'categories_id' => 3,
            //     'brands_id' => 4,
            //     'is_popular' => true,
            //     'stock' => 25,
            // ],
            // [
            //     'name' => 'Jaket Outdoor M231',
            //     'price' => 175000,
            //     'thumbnail' => 'jaket.jpeg',
            //     'about' => 'Jaket tahan angin',
            //     'categories_id' => 4,
            //     'brands_id' => 5,
            //     'is_popular' => false,
            //     'stock' => 15,
            // ],
            // [
            //     'name' => 'Sweater Hangat Cottonology',
            //     'price' => 100000,
            //     'thumbnail' => 'sweater.jpeg',
            //     'about' => 'Sweater adem dan lembut',
            //     'categories_id' => 5,
            //     'brands_id' => 3,
            //     'is_popular' => true,
            //     'stock' => 40,
            // ],
            // [
            //     'name' => 'Kaos Polo Bloods',
            //     'price' => 85000,
            //     'thumbnail' => 'polo.jpeg',
            //     'about' => 'Kaos polo elegan',
            //     'categories_id' => 6,
            //     'brands_id' => 6,
            //     'is_popular' => true,
            //     'stock' => 20,
            // ],
            [
                'name' => 'Kemeja Kotak Pria',
                'price' => 89000,
                'thumbnail' => 'kemeja_kotak.jpeg',
                'about' => 'Kemeja flannel motif kotak warna biru navy',
                'categories_id' => 2,
                'brands_id' => 1,
                'is_popular' => true,
                'stock' => 25,
            ],
            [
                'name' => 'Kemeja Flannel Lengan Panjang',
                'price' => 99000,
                'thumbnail' => 'flannel_lengan_panjang.jpeg',
                'about' => 'Kemeja flannel lengan panjang bahan lembut',
                'categories_id' => 2,
                'brands_id' => 3,
                'is_popular' => false,
                'stock' => 20,
            ],
            [
                'name' => 'Kemeja Flannel Wanita',
                'price' => 85000,
                'thumbnail' => 'flannel_wanita.jpeg',
                'about' => 'Kemeja flannel model oversized untuk wanita',
                'categories_id' => 2,
                'brands_id' => 2,
                'is_popular' => true,
                'stock' => 18,
            ],
            [
                'name' => 'Kemeja Flannel Klasik',
                'price' => 92000,
                'thumbnail' => 'flannel_klasik.jpeg',
                'about' => 'Model klasik dengan motif kotak coklat-hitam',
                'categories_id' => 2,
                'brands_id' => 1,
                'is_popular' => false,
                'stock' => 22,
            ],
            [
                'name' => 'Kemeja Flannel Urban Style',
                'price' => 110000,
                'thumbnail' => 'flannel_urban.jpeg',
                'about' => 'Cocok untuk tampilan kasual sehari-hari',
                'categories_id' => 2,
                'brands_id' => 4,
                'is_popular' => true,
                'stock' => 15,
            ],
            [
                'name' => 'Kemeja Flannel Anak Muda',
                'price' => 97000,
                'thumbnail' => 'flannel_youth.jpeg',
                'about' => 'Tampil gaya dengan motif kekinian',
                'categories_id' => 2,
                'brands_id' => 2,
                'is_popular' => false,
                'stock' => 28,
            ],
            [
                'name' => 'Kemeja Flannel Distro',
                'price' => 105000,
                'thumbnail' => 'flannel_distro.jpeg',
                'about' => 'Kemeja distro berbahan flannel premium',
                'categories_id' => 2,
                'brands_id' => 3,
                'is_popular' => true,
                'stock' => 10,
            ],
        ];

        foreach ($products as $product) {
            Products::create([
                'name' => $product['name'],
                'slug' => Str::slug($product['name']),
                'price' => $product['price'],
                'thumbnail' => $product['thumbnail'],
                'about' => $product['about'],
                'categories_id' => $product['categories_id'],
                'brands_id' => $product['brands_id'],
                'is_popular' => $product['is_popular'],
                'stock' => $product['stock'],
            ]);
        }
    }
}
