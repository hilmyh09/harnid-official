<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Shop;
use Illuminate\Support\Facades\Route;

// Toko (publik)
Route::get('/', Shop\HomeController::class)->name('home');
Route::get('/produk', [Shop\CatalogController::class, 'index'])->name('catalog.index');
Route::get('/new-arrivals', [Shop\CatalogController::class, 'newArrivals'])->name('catalog.new');
Route::get('/sale', [Shop\CatalogController::class, 'sale'])->name('catalog.sale');
Route::get('/kategori/{category}', [Shop\CatalogController::class, 'category'])->name('catalog.category');
Route::get('/koleksi/{collection}', [Shop\CatalogController::class, 'collection'])->name('catalog.collection');
Route::get('/produk/{product}', [Shop\CatalogController::class, 'show'])->name('product.show');

Route::get('/keranjang', [Shop\CartController::class, 'index'])->name('cart.index');
Route::post('/keranjang/{product}', [Shop\CartController::class, 'add'])->name('cart.add');
Route::patch('/keranjang/{key}', [Shop\CartController::class, 'update'])->name('cart.update');
Route::delete('/keranjang/{key}', [Shop\CartController::class, 'remove'])->name('cart.remove');

Route::get('/checkout', [Shop\CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout', [Shop\CheckoutController::class, 'store'])->middleware('throttle:10,1')->name('checkout.store');
Route::get('/pesanan/{order}/berhasil', [Shop\CheckoutController::class, 'success'])->name('checkout.success');

Route::get('/tentang', [Shop\PageController::class, 'about'])->name('about');
Route::get('/toko', [Shop\PageController::class, 'stores'])->name('stores');
Route::get('/panduan-ukuran', [Shop\PageController::class, 'sizeGuide'])->name('size-guide');
Route::get('/kontak', [Shop\ContactController::class, 'show'])->name('contact');
Route::post('/kontak', [Shop\ContactController::class, 'store'])->middleware('throttle:10,1')->name('contact.store');

// Autentikasi admin
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

// Admin
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('/', Admin\DashboardController::class)->name('dashboard');

    Route::resource('produk', Admin\ProductController::class)
        ->parameters(['produk' => 'product'])
        ->names('products')
        ->except(['show']);

    Route::get('/pesanan', [Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/pesanan/{order}', [Admin\OrderController::class, 'show'])->name('orders.show');
    Route::patch('/pesanan/{order}/status', [Admin\OrderController::class, 'updateStatus'])->name('orders.status');

    Route::get('/pesan', [Admin\MessageController::class, 'index'])->name('messages.index');
    Route::patch('/pesan/{message}/dibaca', [Admin\MessageController::class, 'markRead'])->name('messages.read');
});
