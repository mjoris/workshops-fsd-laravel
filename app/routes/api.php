<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*
Route::get('/products/{id}', function ($id) {
    $product = Product::findOrFail($id);
    return $product;
})->where('id', '[0-9]+');

Route::get('/products', function () {
    return Product::all();
});
*/

Route::get('/products/{id}', function ($id) {
    $product = Product::with('brand')->findOrFail($id);
    return ['data' => $product];
})->where('id', '[0-9]+');

Route::get('/products', function () {
    return ['data' => Product::with('brand')->get()];
});

Route::post('/products', function (Request $request) {

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

