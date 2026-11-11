<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\AddressController;

use App\Models\Product;
use App\Models\Category;

Route::get('/', function () {
    $products = Product::with('category')->where('stock', '>', 0)->latest()->get();

    $bestProducts = Product::with('category')
        ->withSum([
            'orderDetails as total_sold' => function ($query) {
                $query->whereHas('order', function ($orderQuery) {
                    $orderQuery->where('order_status', 'Delivered');
                });
            }
        ], 'quantity')
        ->orderByDesc('total_sold')
        ->take(4)
        ->get();
        return view('welcome', compact('products', 'bestProducts'));
    })->name('welcome');

Auth::routes();

Route::get('/search', function (Request $request) {

    $keyword = strtolower(trim($request->search ?? ''));

    if ($keyword === '') {
        return back();
    }

    $homeUrl = url('/');
    $aboutUrl = route('about');
    $productUrl = route('products.index');


    // 1. HOME
    if (
        str_contains($keyword, 'home') ||
        str_contains($keyword, 'beranda') ||
        str_contains($keyword, 'halaman utama')
    ) {
        return redirect($homeUrl . '#home');
    }

    // 2. ABOUT US
    if (
        str_contains($keyword, 'about') ||
        str_contains($keyword, 'tentang') ||
        str_contains($keyword, 'cerita matcha mori') ||
        str_contains($keyword, 'our story')
    ) {
        return redirect($aboutUrl . '#about-story');
    }

    if (
        str_contains($keyword, 'contact') ||
        str_contains($keyword, 'kontak') ||
        str_contains($keyword, 'alamat toko') ||
        str_contains($keyword, 'instagram')
    ) {
        return redirect($aboutUrl . '#about-contact');
    }

    if (
        str_contains($keyword, 'nilai') ||
        str_contains($keyword, 'values') ||
        str_contains($keyword, 'keunggulan')
    ) {
        return redirect($aboutUrl . '#about-values');
    }

    // 3. BEST SELLER
    if (
        str_contains($keyword, 'best seller') ||
        str_contains($keyword, 'terlaris') ||
        str_contains($keyword, 'produk terlaris')
    ) {
        return redirect($homeUrl . '#best-seller');
    }

    // 4. TESTIMONIAL
    if (
        str_contains($keyword, 'testimoni') ||
        str_contains($keyword, 'testimonial') ||
        str_contains($keyword, 'ulasan')
    ) {
        return redirect($homeUrl . '#testimonial');
    }

    // 5. KATEGORI
    if (
        str_contains($keyword, 'kategori') ||
        str_contains($keyword, 'category') ||
        str_contains($keyword, 'categories')
    ) {
        return Auth::check()
            ? redirect()->route('customer.categories.index')
            : redirect($homeUrl . '#collection');
    }

    // Cari nama kategori terlebih dahulu
    $category = Category::where('name', 'LIKE', "%{$keyword}%")->first();

    if ($category) {
        return redirect($productUrl . '?category_id=' . $category->id);
    }

    // 6. MENU / PRODUK
    if (
        str_contains($keyword, 'menu') ||
        str_contains($keyword, 'produk') ||
        str_contains($keyword, 'product') ||
        str_contains($keyword, 'products')
    ) {
        return redirect($productUrl . '#product-list');
    }

    // 7. HARGA DAN STOK
    if (
        str_contains($keyword, 'harga') ||
        str_contains($keyword, 'price') ||
        str_contains($keyword, 'stok') ||
        str_contains($keyword, 'stock')
    ) {
        return redirect()->route('products.index');
    }

    // 8. PRODUK HABIS
    if (
        str_contains($keyword, 'habis') ||
        str_contains($keyword, 'sold out') ||
        str_contains($keyword, 'stok kosong')
    ) {
        return redirect($productUrl . '#sold-out');
    }

    // 9. CARA PEMESANAN
    if (
        str_contains($keyword, 'cara pesan') ||
        str_contains($keyword, 'cara pemesanan') ||
        str_contains($keyword, 'how to order') ||
        str_contains($keyword, 'pemesanan')
    ) {
        return redirect($productUrl . '#product-list');
    }

    // 10. MY ORDERS
    if (
        str_contains($keyword, 'my order') ||
        str_contains($keyword, 'pesanan saya') ||
        str_contains($keyword, 'riwayat pesanan') ||
        str_contains($keyword, 'pesanan')
    ) {
        return Auth::check()
            ? redirect()->route('customer.orders.index')
            : redirect()->route('login');
    }

    // 11. PROFILE
    if (
        str_contains($keyword, 'profile') ||
        str_contains($keyword, 'profil') ||
        str_contains($keyword, 'akun saya')
    ) {
        return Auth::check()
            ? redirect()->route('customer.profile')
            : redirect()->route('login');
    }

    // 12. CART
    if (
        str_contains($keyword, 'cart') ||
        str_contains($keyword, 'keranjang')
    ) {
        return Auth::check()
            ? redirect()->route('customer.cart.index')
            : redirect()->route('login');
    }

    // 13. ADDRESS
    if (
        str_contains($keyword, 'alamat') ||
        str_contains($keyword, 'address')
    ) {
        return Auth::check()
            ? redirect()->route('customer.addresses.index')
            : redirect()->route('login');
    }

    // 14. CARI PRODUK BERDASARKAN NAMA
    $product = Product::where('name', 'LIKE', "%{$keyword}%")->first();

    if ($product) {
        return redirect()->route('products.show', $product->id);
    }

    // 15. CARI DESKRIPSI PRODUK
    $matchingProduct = Product::where('description', 'LIKE', "%{$keyword}%")
        ->first();

    if ($matchingProduct) {
        return redirect()->route('products.show', $matchingProduct->id);
    }

    // 16. PENCARIAN UMUM
    return redirect()->route('products.index', [
        'search' => $keyword
    ]);

})->name('search');

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

    // Order
    Route::get('/orders', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{id}/status', [App\Http\Controllers\Admin\OrderController::class, 'status'])->name('orders.status');
    Route::patch('/orders/{id}/status', [App\Http\Controllers\Admin\OrderController::class, 'update'])->name('orders.update');
    Route::get('/orders/{id}/nota', [App\Http\Controllers\Admin\OrderController::class, 'printNota'])->name('orders.nota');

    Route::get('/customers', [App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/{id}', [App\Http\Controllers\Admin\CustomerController::class, 'show'])->name('customers.show');
    Route::delete('/customers/{id}', [App\Http\Controllers\Admin\CustomerController::class, 'destroy'])->name('customers.destroy');

    // Manage Ulasan
    Route::get('/reviews', [App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('reviews.index');
    Route::delete('/reviews/{id}', [App\Http\Controllers\Admin\ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::get('/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/pdf', [ App\Http\Controllers\Admin\ReportController::class,'exportPdf'])->name('reports.pdf');
});

Route::get('/customer/login', function () {
    return view('auth.login');
})->name('customer.login');

Route::get('/about', function () {
        return view('customers.about');
})->name('about');

    Route::get('/products', [App\Http\Controllers\Customer\ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{id}', [App\Http\Controllers\Customer\ProductController::class, 'show'])->name('products.show');


// Customer
Route::group([
    'prefix' => 'customer',
    'as' => 'customer.',
    'middleware' => ['auth', 'role:customer'],
], function () {

    Route::get('/dashboard', [App\Http\Controllers\Customer\DashboardController::class, 'index'])->name('dashboard');

    // Profile Customer
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    
    // Alamat Customer
    Route::get('/addresses', [AddressController::class, 'index'])->name('addresses.index');
    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::get('/addresses/{id}/edit', [AddressController::class, 'edit'])->name('addresses.edit');
    Route::patch('/addresses/{id}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{id}', [AddressController::class, 'destroy'])->name('addresses.destroy');

    Route::get('/categories', [App\Http\Controllers\Customer\CategoryController::class, 'index'])->name('categories.index');
   
    Route::get('/cart', [App\Http\Controllers\Customer\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [App\Http\Controllers\Customer\CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{id}', [App\Http\Controllers\Customer\CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [App\Http\Controllers\Customer\CartController::class, 'destroy'])->name('cart.destroy');

    // Checkout - Order Form
    Route::get('/checkout/order_form', [App\Http\Controllers\Customer\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/order_form', [App\Http\Controllers\Customer\CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/payment', [App\Http\Controllers\Customer\CheckoutController::class, 'payment'])->name('checkout.payment');
    Route::post('/checkout/payment', [App\Http\Controllers\Customer\CheckoutController::class, 'storePayment'])->name('checkout.payment.store');
    // Halaman hasil pembayaran e-wallet
    Route::get('/checkout/payment-result/{id}', [App\Http\Controllers\Customer\CheckoutController::class, 'paymentResult'])->name('checkout.payment.result');

    Route::get('/checkout/confirmation/{id}', [App\Http\Controllers\Customer\CheckoutController::class, 'confirmation'])->name('checkout.confirmation');
    Route::post('/checkout/simulate-payment', [\App\Http\Controllers\Customer\CheckoutController::class, 'simulatePayment'])->name('checkout.simulate-payment');

    // Order
    Route::get('/orders', [App\Http\Controllers\Customer\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [App\Http\Controllers\Customer\OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{id}/confirm-received', [App\Http\Controllers\Customer\OrderController::class, 'confirmReceived'])->name('orders.confirmReceived');
    Route::post('/orders/{order}/reviews', [App\Http\Controllers\Customer\ReviewController::class, 'store'])->name('reviews.store');
});

