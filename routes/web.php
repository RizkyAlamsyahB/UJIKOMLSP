<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\PromotionController;

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

Route::get('/', [LandingController::class, 'index']);

Auth::routes(['verify' => true]);

// Group routes that require 'auth' and 'checkAdmin' middleware
Route::middleware(['auth', 'checkAdmin'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::resource('categories', CategoryController::class);
    Route::get('categories/data', [CategoryController::class, 'getData'])->name('categories.getData');

    Route::resource('brands', BrandController::class);

    Route::resource('products', ProductsController::class);

    Route::resource('promotions', PromotionController::class);
});

// Public route (no admin check required)
Route::get('/product/{id}', [DetailController::class, 'show'])->name('detail');
Route::post('/cart/add/{productId}', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/chat', [ChatbotController::class, 'handleChat'])->name('chatbot.message');
Route::get('/products/filter', [ProductsController::class, 'filter'])->name('products.filter');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/pay', [CheckoutController::class, 'pay'])->name('checkout.pay');
Route::post('/payment-success', [CheckoutController::class, 'paymentSuccess'])->name('payment.success');


// Rute untuk melihat keranjang belanja
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/items', [CartController::class, 'getCartItems'])->name('cart.items');
Route::post('/cart/add/{productId}', [CartController::class, 'addProduct'])->name('cart.add');
Route::delete('/cart/remove/{productId}', [CartController::class, 'removeProduct'])->name('cart.remove');
Route::post('/cart/update/{productId}', [CartController::class, 'updateProduct'])->name('cart.update');
Route::delete('cart/clear', [CartController::class, 'clear'])->name('cart.clear');
