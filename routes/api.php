<?php

use App\Http\Controllers\Api;
use Illuminate\Support\Facades\Route;

// API publik (JSON) untuk toko. Prefix /api dipasang otomatis oleh bootstrap/app.php.
Route::get('/produk/unggulan', Api\FeaturedProductController::class)
    ->middleware('throttle:60,1')
    ->name('api.products.featured');
