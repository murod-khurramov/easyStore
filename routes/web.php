<?php

use App\Http\Controllers\AdminBookController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/books/create', [AdminBookController::class, 'create'])->name('admin.books.create');
    Route::post('/admin/books', [AdminBookController::class, 'store'])->name('admin.books.store');
});

Route::delete('/admin/books/{book}', [AdminBookController::class, 'destroy'])->name('admin.books.destroy');

Route::middleware('auth')->group(function () {
    Route::post('/cart/{book}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::delete('/cart/{cartItem}', [CartController::class, 'removeFromCart'])->name('cart.remove');

});

Route::prefix('admin')->name('admin.')->group(function() {
    Route::resource('books', AdminBookController::class);
});

Route::get('admin/books/search', [AdminBookController::class, 'search'])->name('admin.books.search');

Route::get('admin/books/statistics', [AdminBookController::class, 'statistics'])->name('admin.books.statistics');

Route::get('admin/books', [AdminBookController::class, 'index'])->name('admin.books.index');

Route::post('admin/books/{id}/rate', [AdminBookController::class, 'rate'])->name('admin.books.rate');

