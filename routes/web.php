<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('cart', CartController::class)
    ->only(['index', 'store', 'destroy']);
Route::resource('products', ProductController::class)
    ->only(['index']);
