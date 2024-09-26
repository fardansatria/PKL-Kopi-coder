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
use App\Http\Controllers\AdminController;
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
    route::post('/user/profile/update', [ProfileUserController::class, 'update'])->name('user.profile.update');
    route::delete('/user/profile', [ProfileUserController::class, 'destroy'])->name('user.profile.destroy');
    route::post('/user/profile/password', [ProfileUserController::class, 'Password'])->name('user.profile.password');

    Route::middleware('auth')->group(function () {
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
        Route::get('/checkout/{product_id}', [CheckoutController::class, 'checkoutFromProduct'])->name('checkout.product');
        Route::get('/success', [CheckoutController::class, 'success'])->name('user.success');
        Route::get('checkout/from-product/{product_id}', [CheckoutController::class, 'checkoutFromProduct'])->name('checkout.fromProduct');

    });



    // Rute CRUD yang dilindungi oleh middleware auth
    Route::resource('/products', ProductController::class);
    Route::resource('/merek', MerekController::class);
    Route::resource('/sliders', SliderController::class);
    
    Route::get('/products/sold', [AdminController::class, 'soldProducts'])->name('product.sold');
    //order di admin
    Route::get('/order', [OrderController::class, 'index'])->name('order.index');
    Route::get('/order/{id}', [OrderController::class, 'show'])->name('order.show');
    Route::patch('/orders/{id}/update-status', [OrderController::class, 'statusUpdate'])->name('order.statusUpdate');
    Route::get('/order_admin_cancel', [OrderController::class, 'admincancelorder'])->name('order.admin-cancel');
    Route::get('/order_admin_completed', [OrderController::class, 'admincompletedorder'])->name('order.admin-completed');

    // Rute untuk filter produk
    Route::get('admin/search', [AdminController::class, 'search'])->name('admin.search');
    Route::get('print_pdf/{id}', [AdminController::class, 'print_pdf']);
});

// Rute untuk daftar pengguna, hanya dapat diakses oleh admin atau pengguna terautentikasi dengan peran tertentu
Route::get('/user', [UserController::class, 'index'])->name('user.index');

// Include rute autentikasi dari Breeze
require __DIR__ . '/auth.php';

Route::get('product_detail/{id}', [HomeController::class, 'product_detail']);
Route::post('confirm_order', [HomeController::class, 'confirm_order'])->middleware(['auth', 'verified']);
Route::get('mycart', [HomeController::class, 'mycart'])->middleware(['auth', 'verified']);
Route::post('/add_cart/{id}', [HomeController::class, 'add_cart'])->middleware(['auth', 'verified']);
Route::delete('/cart_delete/{id}', [HomeController::class, 'cart_delete'])->middleware(['auth', 'verified']);
Route::get('user/search', [HomeController::class, 'user_search']);


Route::get('/user/order', [HomeController::class, 'userOrder'])->name('user.order')->middleware(['auth', 'verified']);
Route::patch('/order/cancel/{id}', [HomeController::class, 'cancelOrder'])->name('order.cancel');

Route::get('/mereks', [HomeController::class, 'userMerek'])->name('user.merek');
Route::get('/products/brand/{slug}', [HomeController::class, 'filterByBrand'])->name('products.filterByBrand');

Route::post('/checkout/shipping', [CheckoutController::class, 'calculateShipping'])->name('checkout.calculateShipping');
Route::get('/get-cities/{province_id}', [CheckoutController::class, 'getCities']);
Route::post('/calculate-shipping', [CheckoutController::class, 'calculateShipping']);
Route::post('get-shipping-cost', [CheckoutController::class, 'getShippingCost']);



