<?php

use App\Http\Controllers\AdminBookController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
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

Route::get('user/profile', [UserController::class, 'showProfile'])->name('user.profile');

Route::get('user/orders', [UserController::class, 'showOrders'])->name('user.orders.index');

Route::post('user/orders/{order}/update-status', [UserController::class, 'updateOrderStatus'])->name('user.orders.update-status');

Route::get('admin/books', [AdminBookController::class, 'index'])->name('admin.books.index');

Route::get('admin/users', [AdminUserController::class, 'manageUsers'])->name('admin.users.index');
Route::get('admin/users/{user}/edit', [AdminUserController::class, 'editUser'])->name('admin.users.edit');
Route::put('admin/users/{user}', [AdminUserController::class, 'updateUser'])->name('admin.users.update');

Route::get('admin/books/create', [AdminBookController::class, 'create'])->name('admin.books.create');
Route::post('admin/books', [AdminBookController::class, 'store'])->name('admin.books.store');

Route::middleware('auth')->group(function () {
    Route::post('user/orders/{order}/update-status', [UserController::class, 'updateOrderStatus'])->name('user.orders.update-status');
});
