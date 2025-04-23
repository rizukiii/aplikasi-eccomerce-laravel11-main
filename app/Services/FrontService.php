<?php

namespace App\Services;

use App\Repositories\Contracts\CategoryRepositoriInterface;
use App\Repositories\Contracts\ProductRepositoriInterface;

class FrontService
{
    protected $categoryRepository;
    protected $productRepository;

    public function __construct(
        CategoryRepositoriInterface $categoryRepository,
        ProductRepositoriInterface $productRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
    }

    public function getFrontPage(): array
    {
        $categories = $this->categoryRepository->getAllCategories();
        $products = $this->productRepository->getAllNewProduct();
        $bannerProducts = $this->productRepository->getRandomProductByThisWeek(2);
        $latestProducts = $this->productRepository->getLatestProducts(3);
        $brands = $this->productRepository->getAllBrands();
        $popularProducts = $this->productRepository->getPopularProduct(5);

        return [
            'latestProducts' => $latestProducts,
            'brands' => $brands,
            'popularProducts' => $popularProducts,
            'categories' => $categories,
            'bannerProducts' => $bannerProducts,
            'products' => $products,
        ];
    }
}
