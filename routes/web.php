<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/technology', [PageController::class, 'technology'])->name('technology');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

require __DIR__.'/admin.php';
