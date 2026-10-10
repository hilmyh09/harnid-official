<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Str;
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
            'featuredProducts' => $this->featuredProducts(),
            'storeCount' => Store::count(),
            'cityCount' => Store::distinct('city')->count('city'),
        ]);
    }

    /**
     * Produk sorotan: produk unggulan, lalu produk terbaru bila belum ada yang
     * ditandai unggulan, lalu kartu tiruan bila katalog masih kosong.
     *
     * @return EloquentCollection<int, Product>
     */
    private function featuredProducts(): EloquentCollection
    {
        $products = Product::published()->with('category')->where('is_featured', true)->take(4)->get();

        if ($products->isEmpty()) {
            $products = Product::published()->with('category')->latest('published_at')->take(4)->get();
        }

        return $products->isEmpty() ? $this->mockFeaturedProducts() : $products;
    }

    /**
     * Kartu produk tiruan untuk homepage saat katalog kosong. Model tidak
     * disimpan ke database; tautan kartu jatuh ke halaman katalog.
     *
     * @return EloquentCollection<int, Product>
     */
    private function mockFeaturedProducts(): EloquentCollection
    {
        $category = new Category(['name' => 'Contoh', 'slug' => 'contoh']);

        $samples = [
            ['Kirana Dress Ivory', 589000, null, '/images/products/dress-ivory.svg'],
            ['Noir Satin Scarf', 229000, null, '/images/products/scarf-noir.svg'],
            ['Sora Tunic Camel', 329000, 379000, '/images/products/outer-camel.svg'],
            ['Everyday Set Mocha', 459000, null, '/images/products/set-mocha.svg'],
        ];

        return new EloquentCollection(array_map(function (array $s) use ($category) {
            $product = new Product([
                'name' => $s[0],
                'slug' => Str::slug($s[0]),
                'price' => $s[1],
                'compare_at_price' => $s[2],
                'image_path' => $s[3],
                'stock' => 10,
                'is_active' => true,
                'published_at' => now(),
            ]);
            $product->setRelation('category', $category);

            return $product;
        }, $samples));
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
