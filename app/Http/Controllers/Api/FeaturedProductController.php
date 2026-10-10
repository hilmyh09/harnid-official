<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * GET /api/produk/unggulan — produk sorotan untuk homepage.
 * Mengembalikan produk tayang yang ditandai unggulan; bila belum ada,
 * jatuh ke produk terbaru agar homepage tidak kosong. Parameter `limit` 1–12 (default 4).
 */
class FeaturedProductController extends Controller
{
    public function __invoke(Request $request): AnonymousResourceCollection
    {
        $limit = (int) $request->integer('limit', 4);
        $limit = max(1, min($limit, 12));

        $products = Product::featuredForHome()->take($limit)->get();

        if ($products->isEmpty()) {
            $products = Product::published()->with('category')->latest('published_at')->take($limit)->get();
        }

        return ProductResource::collection($products);
    }
}
