<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PromoCodes extends Model
{
    use HasFactory;
    protected $table ='promo_codes';
    protected $primary_key = 'id';
    protected $fillable = ['discount_amount','code'];

    public function product():HasMany{
        return $this->hasMany(Products::class);
    }
}
