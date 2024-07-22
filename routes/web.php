<?php

<<<<<<< HEAD
use App\Http\Controllers\ProfileController;
=======
>>>>>>> 5c32dd7 (second commit)
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

<<<<<<< HEAD
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
=======
Route::get('/index', function () {
    return view('adminpage.index');
});

Route::resource('/products', App\Http\Controllers\ProductController::class);
Route::resource('/merek', App\Http\Controllers\MerekController::class);
Route::resource('/sliders', App\Http\Controllers\SliderController::class);

>>>>>>> 5c32dd7 (second commit)
