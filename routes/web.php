<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MerekController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileUserController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// Rute untuk dashboard admin, hanya dapat diakses oleh admin dan pengguna terautentikasi
Route::get('/index', [HomeController::class, 'index'])->middleware(['auth', 'admin'])->name('admin.index');


// Rute untuk halaman utama
Route::get('/', [HomeController::class, 'home']);

Route::get('/dashboard', [HomeController::class, 'home_login'])
    ->middleware(['auth', 'verified'])->name('dashboard');


//rute untuk user yag sudah login

// Rute untuk profil admin`
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //rute untuk profile user
    route::get('/user/profile', [ProfileUserController::class, 'edit'])->name('user.profile.edit');
    route::post('/user/profile', [ProfileUserController::class, 'update'])->name('user.profile.update');
    route::delete('/user/profile', [ProfileUserController::class, 'destroy'])->name('user.profile.destroy');
    route::post('/user/profile', [ProfileUserController::class, 'Password'])->name('user.profile.password');

    Route::middleware('auth')->group(function () {
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
        Route::get('/checkout/{product_id}', [CheckoutController::class, 'checkoutFromProduct'])->name('checkout.product');
        Route::get('/success', [CheckoutController::class, 'success'])->name('user.success');
    });



    // Rute CRUD yang dilindungi oleh middleware auth
    Route::resource('/products', ProductController::class);
    Route::resource('/merek', MerekController::class);
    Route::resource('/sliders', SliderController::class);

    //order di admin
    Route::get('/order', [OrderController::class, 'index'])->name('order.index');
    Route::get('/order/{id}', [OrderController::class, 'show'])->name('order.show');
    Route::patch('/orders/{id}/update-status', [OrderController::class, 'statusUpdate'])->name('order.statusUpdate');

    // Rute untuk filter produk
    Route::get('dashboard/products/filter', [ProductController::class, 'filter'])->name('products.filter');
});

// Rute untuk daftar pengguna, hanya dapat diakses oleh admin atau pengguna terautentikasi dengan peran tertentu
Route::get('/user', [UserController::class, 'index'])->name('user.index');

// Include rute autentikasi dari Breeze
require __DIR__ . '/auth.php';

Route::get('product_detail/{id}', [HomeController::class, 'product_detail']);

Route::get('add_cart/{id}', [HomeController::class, 'add_cart'])->middleware(['auth', 'verified']);

Route::post('confirm_order', [HomeController::class, 'confirm_order'])->middleware(['auth', 'verified']);

Route::get('mycart', [HomeController::class, 'mycart'])->middleware(['auth', 'verified']);
Route::post('/add_cart/{id}', [HomeController::class, 'add_cart'])->middleware(['auth', 'verified']);
Route::delete('/cart_delete/{id}', [HomeController::class, 'cart_delete'])->middleware(['auth', 'verified']);
