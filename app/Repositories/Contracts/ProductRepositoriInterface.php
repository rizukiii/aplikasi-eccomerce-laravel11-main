<?php

namespace App\Repositories\Contracts;

interface ProductRepositoriInterface
{

    public function getPopularProduct($limit);
    public function getAllNewProduct();
    public function find($id);
    public function getPrice($prodId);
    public function getRandomProductByThisWeek($limit);
    public function getLatestProducts($limit);
    public function getAllBrands();
    public function findProductSize($id);
    public function findPromoCode($code);


}
