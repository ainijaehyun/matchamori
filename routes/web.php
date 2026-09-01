<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\CartController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/admin/login', function () {
    return view('auth.adminlogin');
})->name('admin.login');

// Admin
Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => ['auth', 'role:admin'],
], function () {

    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Profile Admin
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    
    Route::resource('/categories', App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('/products', App\Http\Controllers\Admin\ProductController::class);
    Route::get('/orders', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{id}', [App\Http\Controllers\Admin\OrderController::class, 'update'])->name('orders.update');
    Route::get('/customers', [App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/{id}', [App\Http\Controllers\Admin\CustomerController::class, 'show'])->name('customers.show');
    Route::get('/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
});

Route::get('/customer/login', function () {
    return view('auth.login');
})->name('customer.login');

// Customer
Route::group([
    'prefix' => 'customer',
    'as' => 'customer.',
    'middleware' => ['auth', 'role:customer'],
], function () {

    Route::get('/dashboard', [App\Http\Controllers\Customer\DashboardController::class, 'index'])->name('dashboard');

    // Profile Customer
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    
    Route::get('/products', [App\Http\Controllers\Customer\ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{id}', [App\Http\Controllers\Customer\ProductController::class, 'show'])->name('products.show');

    Route::get('/cart', [App\Http\Controllers\Customer\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [App\Http\Controllers\Customer\CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{id}', [App\Http\Controllers\Customer\CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [App\Http\Controllers\Customer\CartController::class, 'destroy'])->name('cart.destroy');

    Route::get('/checkout', [App\Http\Controllers\Customer\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [App\Http\Controllers\Customer\OrderController::class, 'store'])->name('checkout.store');
});

