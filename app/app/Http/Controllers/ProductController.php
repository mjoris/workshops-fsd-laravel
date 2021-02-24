<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //

    public function overview() {
        dd(Product::find(1)->brand->name);

    }

}
