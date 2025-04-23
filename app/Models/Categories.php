<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;


class Categories extends Model
{
    use HasFactory;
    protected $table ='categories';
    protected $primary_key = 'id';
    protected $fillable = ['name','slug','icon'];

    public function product():HasMany{
        return $this->hasMany(Products::class);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
    
}
