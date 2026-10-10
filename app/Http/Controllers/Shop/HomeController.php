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
            'hero' => $this->heroContent(),
            'categories' => Category::orderBy('sort_order')->get(),
            'featuredCollection' => Collection::where('is_featured', true)->orderBy('sort_order')->first(),
            'newArrivals' => Product::published()->with('category')->latest('published_at')->take(8)->get(),
            'featuredProducts' => Product::published()->with('category')->where('is_featured', true)->take(4)->get(),
            'storeCount' => Store::count(),
            'cityCount' => Store::distinct('city')->count('city'),
        ]);
    }

    /**
     * Isi hero homepage. Masih data tiruan (statis); nanti bisa dipindah ke
     * pengaturan admin tanpa mengubah komponen `x-sections.hero`.
     *
     * @return array<string, string>
     */
    private function heroContent(): array
    {
        return [
            'eyebrow' => 'Koleksi terbaru',
            'title' => 'Modest fashion yang rapi, nyaman, dan siap dipakai.',
            'subtitle' => config('company.tagline').'. Ready-to-wear dari kasual hingga formal, dikirim ke seluruh Indonesia.',
            'image' => '/images/campaign/hero.jpg',
            'image_alt' => 'Tiga model mengenakan Harnid Basic Shirt warna cokelat, abu-abu, dan hitam',
            'cta_label' => 'Mulai Belanja',
            'cta_url' => route('catalog.index'),
            'secondary_label' => 'New Arrivals',
            'secondary_url' => route('catalog.new'),
        ];
    }
}
