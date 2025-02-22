<?php

use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

// The single route you get on a fresh install
/*
Route::get('/', function () {
    return view('welcome');
});
*/

// When at '/', redirect to the (static) course slides
Route::get('/', function (): RedirectResponse {
    return redirect('/slides');
});

// Route for demos on types in 03.lets.mvc
Route::get('/types-demo', function (Request $request): void {
    if ($request->has('qb-1')) {
        $users = DB::table('users')->get();
        dump($users);
    }
    if ($request->has('qb-2')) {
        $select = DB::table('users')->select('name', 'email as user_email')->where('status', '<>', 1);
        dump($select);
    }
    if ($request->has('elo-1')) {
        $products = Product::all();
        dump($products);
    }
    if ($request->has('elo-2')) {
        $product = Product::find(1);
        dump($product);
    }
});


// Routes for concluding demo 'webshop' of 03.lets.mvc
Route::get('/eloquent-demo-1', [ProductController::class, 'demo1']);
Route::get('/eloquent-demo-2', [ProductController::class, 'demo2']);
Route::get('/eloquent-demo-3', [ProductController::class, 'demo3']);
Route::get('/eloquent-demo-4', [ProductController::class, 'demo4']);
Route::get('/eloquent-demo-5', [ProductController::class, 'demo5']);

// Routes for concluding demo 'webshop' of 04.forms

Route::get('/products', [ProductController::class, 'overview']);
Route::get('/products/{product}', [ProductController::class, 'show'])->whereNumber('product');

Route::get('/products/create', [ProductController::class, 'showCreateForm']);
Route::post('/products/create', [ProductController::class, 'create']);

