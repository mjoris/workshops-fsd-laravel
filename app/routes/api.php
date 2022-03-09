<?php

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Version 1: relying on Eloquent serialization

Route::get('/v1/products/{id}', function ($id) {
    $product = Product::findOrFail($id);
    return $product;
})->where('id', '[0-9]+');


Route::get('/v1/products', function () {
    return Product::all();
});


// Version 2: same, with LOADED relationship and wrapping

Route::get('/v2/products/{id}', function ($id) {
    $product = Product::with('brand')->findOrFail($id);
    return ['data' => $product];
})->where('id', '[0-9]+');


Route::get('/v2/products', function () {
    return ['data' => Product::with('brand')->get()];
});

Route::post('/v2/products', function (Request $request) {

    $request->validate([
        'name' => 'required|unique:products|max:125',
        'price' => 'required|numeric|min:0.10',
        'description' => 'required',
        'brand_id' => 'required|exists:brands,id'
    ]);

    $product = new Product($request->all());
    $product->user()->associate(Auth::user());
    $product->save();
    return ['message' => 'The product has been created'];
});


// Version 3: relying on Eloquent API Resources

Route::get('/v3/products/{id}', function ($id) {
    return new ProductResource(Product::findOrFail($id));
});

Route::get('/v3/products', function () {
    // return new ProductCollection(Product::all());
    // if you don't have a ProductCollection:
    return ProductResource::collection(Product::all());
});



// Under construction ...

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/v4/products', function (Request $request) {

    Gate::authorize('add-product');

    $request->validate([
        'name' => 'required|unique:products|max:125',
        'price' => 'required|numeric|min:0.10',
        'description' => 'required',
        'brand_id' => 'required|exists:brands,id'
    ]);

    $product = new Product($request->all());
    $product->user()->associate(Auth::user());
    $product->save();
    return ['message' => 'The product has been created'];
})->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->get('/secret1', function (Request $request) {
    return $request->user();
});

