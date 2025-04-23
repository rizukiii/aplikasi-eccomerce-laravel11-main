<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductTransactions extends Model
{
    use HasFactory;
    protected $table='product_transactions';
    protected $primaryKey='id';
    protected $fillable=['name','phone','email','booking_trx_id','city','post_code','proof','address','product_sizes_id','quantity','sub_total_amount','grand_total_amount','discount_amount','is_paid','products_id','promo_codes_id'];

    public function productSize():BelongsTo{
        return $this->belongsTo(ProductSizes::class,'product_sizes_id');
    }
    public function product():BelongsTo{
        return $this->belongsTo(Products::class,'products_id');
    }
    public function promo():BelongsTo{
        return $this->belongsTo(PromoCodes::class, 'promo_codes_id');
    }

    public function uniqGenerateTrxId(){
        $prefix='PTO';
        do {
            $randomString = $prefix.mt_rand(1000,9999);
        } while (self::where('booking_trx_id', $randomString)->exists());

        return $randomString;
    }
}
