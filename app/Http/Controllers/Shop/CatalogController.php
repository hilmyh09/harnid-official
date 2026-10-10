<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(Request $request): View
    {
        return $this->render($request, Product::published(), 'Semua Produk', 'Seluruh koleksi siap pakai Harnid Official.');
    }

    public function newArrivals(Request $request): View
    {
        return $this->render($request, Product::published()->where('published_at', '>=', now()->subDays(60)), 'New Arrivals', 'Rilisan terbaru 60 hari terakhir.');
    }

    public function sale(Request $request): View
    {
        return $this->render($request, Product::published()->whereNotNull('compare_at_price')->whereColumn('compare_at_price', '>', 'price'), 'Sale', 'Harga spesial untuk pilihan tertentu.');
    }

    public function category(Request $request, Category $category): View
    {
        return $this->render($request, Product::published()->where('category_id', $category->id), $category->name, $category->description, $category);
    }

    public function collection(Request $request, Collection $collection): View
    {
        return $this->render($request, Product::published()->where('collection_id', $collection->id), $collection->name, $collection->description);
    }

    public function show(Product $product): View
    {
        abort_unless($product->isPublished(), 404);

        $product->load(['category', 'collection']);

        return view('shop.product', [
            'product' => $product,
            'related' => Product::published()
                ->where('category_id', $product->category_id)
                ->whereKeyNot($product->id)
                ->take(4)
                ->get(),
        ]);
    }

    private function render(Request $request, Builder $query, string $title, ?string $subtitle = null, ?Category $activeCategory = null): View
    {
        $search = trim((string) $request->query('q', ''));
        $sort = $request->query('urut', 'terbaru');

        if ($search !== '') {
            $query->where(fn (Builder $q) => $q
                ->whereLike('name', "%{$search}%")
                ->orWhereLike('sku', "%{$search}%"));
        }

        match ($sort) {
            'termurah' => $query->orderBy('price'),
            'termahal' => $query->orderByDesc('price'),
            default => $query->orderByDesc('published_at'),
        };

        return view('shop.catalog', [
            'title' => $title,
            'subtitle' => $subtitle,
            'products' => $query->with('category')->orderByDesc('id')->paginate(12)->withQueryString(),
            'categories' => Category::orderBy('sort_order')->get(),
            'activeCategory' => $activeCategory,
            'search' => $search,
            'sort' => $sort,
        ]);
    }
}
