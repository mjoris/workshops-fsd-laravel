<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// The single route you get on a fresh install
/*
Route::get('/', function () {
    return view('welcome');
});
*/

// When at '/', redirect to the (static) course slides
Route::get('/', function () {
    return redirect('/slides');
});

// Routes for concluding demo 'webshop' of 02.lets.mvc
Route::get('/eloquent-demo-1', [ProductController::class, 'demo1']);
Route::get('/eloquent-demo-2', [ProductController::class, 'demo2']);
Route::get('/eloquent-demo-3', [ProductController::class, 'demo3']);
Route::get('/eloquent-demo-4', [ProductController::class, 'demo4']);

Route::get('/products', [ProductController::class, 'overview']);
Route::get('/products/{product}', [ProductController::class, 'show'])->where(['product' => '[0-9]+']);

Route::get('/products/create', [ProductController::class, 'showCreateForm'])->middleware(['auth']);
Route::post('/products/create', [ProductController::class, 'create'])->middleware(['auth']);

require __DIR__.'/auth.php';


Route::post('/sanctum/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        // $request->session()->regenerate();
        return response(['message' => 'The user has been authenticated successfully'], 200);
    }
    return response(['message' => 'The provided credentials do not match our records.'], 401);

});

Route::post('/sanctum/logout', function (Request $request) {
    Auth::guard('web')->logout();
    $request->session()->invalidate();
    return response(['message' => 'The user has been logged out successfully'], 200);
});
