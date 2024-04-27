<?php

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


// Version 1: relying on Eloquent serialization

Route::get('/v1/products/{id}', function (string $id): Product {
    $product = Product::findOrFail($id);
    return $product;
})->where('id', '[0-9]+');


Route::get('/v1/products', function (): Collection {
    return Product::all();
});


// Version 2: same, with LOADED relationship and wrapping

Route::get('/v2/products/{id}', function (string $id): array {
    $product = Product::with('brand')->findOrFail($id);
    return ['data' => $product];
})->where('id', '[0-9]+');


Route::get('/v2/products', function (): array {
    return ['data' => Product::with('brand')->get()];
});

Route::post('/v2/products', function (Request $request): array {

    $request->validate([
        'name' => 'required|unique:products|max:125',
        'price' => 'required|numeric|min:0.10',
        'description' => 'required',
        'brand_id' => 'required|exists:brands,id'
    ]);

    $product = new Product($request->all());
    // $product->user()->associate(Auth::user());
    $product->save();
    return ['message' => 'The product has been created'];
});


// Version 3: relying on Eloquent API Resources

Route::get('/v3/products/{id}', function (string $id): ProductResource {
    return new ProductResource(Product::findOrFail($id));
});

Route::get('/v3/products', function (): \Illuminate\Http\Resources\Json\ResourceCollection {
    // return new ProductCollection(Product::all());
    // if you don't have a ProductCollection:
    return ProductResource::collection(Product::all());
});



// Version 4: adding products with authentication & authorization

Route::middleware('auth:sanctum')->get('/secret1', function (Request $request): User {
    return $request->user();
});

Route::post('/v4/products', function (Request $request): array {

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
