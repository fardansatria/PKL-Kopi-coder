<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\UserController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/index', function () {
    return view('admin-feature.adminpage.index');
});

Route::resource('/products', App\Http\Controllers\ProductController::class);
Route::resource('/merek', App\Http\Controllers\MerekController::class);
Route::resource('/sliders', App\Http\Controllers\SliderController::class);

Route::get('/user', [SliderController::class, 'showProductsAndSliders'])->name('user.index');
Route::get('/products/filter', [ProductController::class, 'filter'])->name('products.filter');
Route::get('/user', [UserController::class, 'index'])->name('user.index');
Route::get('/user/{id}', [UserController::class, 'show'])->name('user.show');
