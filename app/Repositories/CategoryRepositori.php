<?php

namespace App\Repositories;

use App\Models\Categories;
use App\Repositories\Contracts\CategoryRepositoriInterface;

class CategoryRepositori implements CategoryRepositoriInterface
{
    public function getAllCategories()
    {
        return Categories::latest()->get();
    }
}
