<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImages extends Model
{
    use HasFactory;
    protected $table ='product_images';
    protected $primary_key = 'id';
    protected $fillable = ['products_id','photo'];

    public function product() : BelongsTo {
        return $this->belongsTo(Products::class,'products_id');
    }
}
