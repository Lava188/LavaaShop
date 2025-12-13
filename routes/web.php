<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\StoreController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreAdmin\DashboardController as StoreDashboardController;
use App\Http\Controllers\StoreAdmin\ProductController as StoreProductController;
use App\Http\Controllers\StoreAdmin\OrderController as StoreOrderController;
use App\Http\Controllers\StorefrontController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;

Route::get('/', function () {   
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', [StorefrontController::class, 'home'])->name('home');
Route::get('/stores/{store}', [StorefrontController::class, 'store'])->name('stores.show');
Route::get('/products/{product}', [StorefrontController::class, 'product'])->name('products.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{productId}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('/my-orders', [CustomerOrderController::class, 'index'])->name('customer.orders.index');
    Route::get('/my-orders/{order}', [CustomerOrderController::class, 'show'])->name('customer.orders.show');
});

Route::middleware(['auth','store_admin'])
    ->prefix('store-admin')
    ->name('store.')
    ->group(function () {
        Route::get('/dashboard', [StoreDashboardController::class, 'index'])->name('dashboard');

        Route::resource('products', StoreProductController::class)
            ->only(['index','create','store','edit','update','destroy']);

        Route::resource('orders', StoreOrderController::class)
            ->only(['index','show','update']);
    });

require __DIR__.'/auth.php';
