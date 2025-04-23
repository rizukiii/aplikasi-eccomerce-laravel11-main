<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductSizes extends Model
{
    use HasFactory;
    protected $table = 'product_sizes';
    protected $primaryKey = 'id';
    protected $fillable = ['products_id', 'size'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Products::class, 'products_id');
    }
}
