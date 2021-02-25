<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

// Eloquent model for concluding demo 'webshop' of 02.lets.mvc
class ProductController extends Controller
{

    public function overview() {
        dd(Product::find(1)->brand->name);
    }

}
