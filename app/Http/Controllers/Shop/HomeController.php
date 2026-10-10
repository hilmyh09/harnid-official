<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use App\Models\Store;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('shop.home', [
            'categories' => Category::orderBy('sort_order')->get(),
            'featuredCollection' => Collection::where('is_featured', true)->orderBy('sort_order')->first(),
            'newArrivals' => Product::published()->with('category')->latest('published_at')->take(8)->get(),
            'featuredProducts' => Product::published()->with('category')->where('is_featured', true)->take(4)->get(),
            'storeCount' => Store::count(),
            'cityCount' => Store::distinct('city')->count('city'),
        ]);
    }
}
