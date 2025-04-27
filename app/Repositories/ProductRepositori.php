<?php

namespace App\Repositories;

use App\Models\Brands;
use App\Models\Products;
use App\Models\ProductSizes;
use App\Models\PromoCodes;
use App\Repositories\Contracts\ProductRepositoriInterface;
use Carbon\Carbon;

class ProductRepositori implements ProductRepositoriInterface
{
    public function getPopularProduct($limit = 5)
    {
        return Products::with('photos')->where('is_popular', true)->take($limit)->get();
    }
    public function getAllNewProduct()
    {
        return Products::latest()->get();
    }
    public function find($id)
    {
        return Products::find($id);
    }
    public function getPrice($prodId)
    {
        $prod = $this->find($prodId);
        return $prod ? $prod->price : 0;
    }
    public function getRandomProductByThisWeek($limit = 2)
    {
        return Products::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])
            ->inRandomOrder()
            ->take($limit)
            ->get();
    }

    public function getLatestProducts($limit = 3)
    {
        return Products::latest()->take($limit)->get();
    }
    public function getAllBrands()
    {
        return Brands::all();
    }

    public function findProductSize($id){
        return ProductSizes::find($id);
    }
    public function findPromoCode($code){
        return PromoCodes::where('code',$code)->first();
    }
}
