<?php

namespace App\Repositories\Contracts;

interface PromoCodeRepositoriInterface
{
    
    public function getAllPromosCode();
    public function findByCode(string $code);
}