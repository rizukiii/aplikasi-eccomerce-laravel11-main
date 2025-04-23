<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Products extends Model
{
    use HasFactory;
    protected $table='products';
    protected $primaryKey='id';
    protected $fillable=['name','slug','thumbnail','about','price','is_popular','brands_id','categories_id','stock'];


    public function categories():BelongsTo{
        return $this->belongsTo(Categories::class, 'categories_id');
    }

    public function brands():BelongsTo{
        return $this->belongsTo(Brands::class,'brands_id');
    }

    public function photos():HasMany{
        return $this->hasMany(ProductImages::class);
    }

    public function sizes():HasMany{
        return $this->hasMany(ProductSizes::class);
    }


    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

}
