<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MerekController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Rute untuk dashboard admin, hanya dapat diakses oleh admin dan pengguna terautentikasi
Route::get('/index', [HomeController::class, 'index'])->middleware(['auth', 'admin'])->name('admin.index');


// Rute untuk halaman utama
Route::get('/', [HomeController::class, 'home']);

Route::get('/dashboard', [HomeController::class, 'home_login'])
->middleware(['auth', 'verified'])->name('dashboard');


//rute untuk user yag sudah login

// Rute untuk profil pengguna
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute CRUD yang dilindungi oleh middleware auth
    Route::resource('/products', ProductController::class);
    Route::resource('/merek', MerekController::class);
    Route::resource('/sliders', SliderController::class);

    // Rute untuk filter produk
    Route::get('dashboard/products/filter', [ProductController::class, 'filter'])->name('products.filter');
});

// Rute untuk daftar pengguna, hanya dapat diakses oleh admin atau pengguna terautentikasi dengan peran tertentu
Route::get('/user', [UserController::class, 'index'])->name('user.index');

// Include rute autentikasi dari Breeze
require __DIR__ . '/auth.php';
