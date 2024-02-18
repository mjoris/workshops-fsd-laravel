<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
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
