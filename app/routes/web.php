<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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


Route::get('/', function () {
    return redirect('/slides');
});


Route::get('/products', [ProductController::class, 'overview']);
