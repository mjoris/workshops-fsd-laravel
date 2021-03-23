<?php

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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


Route::get('/products/{id}', function ($id) {
    $product = Product::findOrFail($id);
    return $product;
})->where('id', '[0-9]+');

Route::get('/products', function () {
    return Product::all();
});

/*
Route::get('/products/{id}', function ($id) {
    $product = Product::with('brand')->findOrFail($id);
    return ['data' => $product];
})->where('id', '[0-9]+');

Route::get('/products', function () {
    return ['data' => Product::with('brand')->get()];
});
*/

Route::post('/products', function (Request $request) {

    $request->validate([
        'name' => 'required|unique:products|max:125',
        'price' => 'required|numeric|min:0.10',
        'description' => 'required',
        'brand_id' => 'required|exists:brands,id'
    ]);

    $product = new Product($request->all());
    $product->user_id = 1; // we don't have authentication yet
    $product->save();
    return ['message' => 'The product has been created'];
});

/*
Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return response(['message' => 'The user has been authenticated successfully'], 401);
    }
    return ['message' => 'The provided credentials do not match our records.'];

});*/

