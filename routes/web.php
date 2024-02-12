<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;

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

Route::get('/', function () {
    // return view('welcome');
});

Route::get('/', [ProductController::class, 'list'])->name('product.list');
Route::get('/cart', [CartController::class, 'list'])->name('cart.list');
Route::post('/update-cart', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('/update-discount', [CartController::class, 'updateDiscount'])->name('discount.update');
Route::get('/delete-cart/{id}', [CartController::class, 'destroy'])->name('cart.delete');
Route::post('/update/qty', [CartController::class, 'updateQty'])->name('update.qty');
Route::post('/add/cart', [CartController::class, 'addCart'])->name('add.cart');