<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ProductControllerWithAuth extends Controller
{
    public function overview()
    {
        return view('simple-admin-v2.products', ['products' => Product::all()]);
    }

    public function show(Product $product)
    {
        return view('simple-admin-v2.product-detail', ['product' => $product]);
    }

    public function showCreateForm()
    {
        Gate::authorize('add-product'); // new

        return view('simple-admin-v2.product-add', ['brands' => Brand::all()]);
    }

    public function create(Request $request)
    {
        Gate::authorize('add-product'); // new

        $request->validate([
            'name' => 'required|unique:products|max:125',
            'price' => 'required|numeric|min:0.10',
            'description' => 'nullable',
            'brand_id' => 'required|exists:brands,id'
        ]);

        $product = new Product($request->all());

        // description might be NULL, but this is not allowed in the DB model
        if (! $request->filled('description')) {
            $product->description = '';
        }

        $product->user()->associate(Auth::user()); // new !!
        $product->save();

        return redirect('products');

    }
}
