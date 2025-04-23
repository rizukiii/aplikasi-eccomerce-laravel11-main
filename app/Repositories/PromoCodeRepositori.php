<?php

namespace App\Repositories;

use App\Models\PromoCodes;
use App\Repositories\Contracts\PromoCodeRepositoriInterface;

class PromoCodeRepositori implements PromoCodeRepositoriInterface
{
    public function getAllPromosCode()
    {
        return PromoCodes::latest()->get();
    }

    public function findByCode(string $code)
    {
        return PromoCodes::where('code', $code)->first();
    }
}