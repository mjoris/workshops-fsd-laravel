<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Eloquent model for concluding demo 'webshop' of 02.lets.mvc
class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'brand_id'];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
