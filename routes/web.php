<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StripeController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

//laravel
Route::get('/dashboard', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//vue js

Route::get('/', [PosController::class, 'index'])->name('pos.index');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

// Stripe Payment Routes
Route::post('/create-checkout-session', [StripeController::class, 'createCheckoutSession'])->name('payment.checkout');
Route::get('/payment/success/{order}', [StripeController::class, 'success'])->name('payment.success');
Route::get('/payment/cancel/{order}', [StripeController::class, 'cancel'])->name('payment.cancel');
Route::get('/invoice/{order}/download', [StripeController::class, 'downloadInvoice'])->name('invoice.download');

require __DIR__.'/auth.php';
