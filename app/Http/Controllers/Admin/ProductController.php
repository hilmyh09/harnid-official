<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));

        $products = Product::with('category')
            ->when($search !== '', fn ($q) => $q->where(fn ($w) => $w->whereLike('name', "%{$search}%")->orWhereLike('sku', "%{$search}%")))
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        return view('admin.products.index', ['products' => $products, 'search' => $search]);
    }

    public function create(): View
    {
        return view('admin.products.form', $this->formData(new Product(['is_active' => true, 'stock' => 0])));
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        $product = new Product($this->attributes($request));
        $product->published_at = $request->boolean('published') ? now() : null;

        if ($request->hasFile('image')) {
            $product->image_path = $request->file('image')->store('products', 'public');
        }

        $product->gallery = $this->storeGallery($request, []);
        $product->save();

        return redirect()->route('admin.products.index')->with('status', 'Produk ditambahkan.');
    }

    public function edit(Product $product): View
    {
        return view('admin.products.form', $this->formData($product));
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $product->fill($this->attributes($request));

        if ($request->boolean('published') && $product->published_at === null) {
            $product->published_at = now();
        } elseif (! $request->boolean('published')) {
            $product->published_at = null;
        }

        if ($request->hasFile('image')) {
            if ($product->image_path && ! str_starts_with($product->image_path, '/')) {
                Storage::disk('public')->delete($product->image_path);
            }
            $product->image_path = $request->file('image')->store('products', 'public');
        }

        $keep = array_values(array_diff($product->gallery ?? [], $request->input('remove_gallery', [])));
        $product->gallery = $this->storeGallery($request, $keep);
        $product->save();

        return redirect()->route('admin.products.index')->with('status', 'Produk diperbarui.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->update(['is_active' => false, 'published_at' => null]);

        return redirect()->route('admin.products.index')->with('status', 'Produk dinonaktifkan dan disembunyikan dari toko.');
    }

    /** @return array<string, mixed> */
    private function formData(Product $product): array
    {
        return [
            'product' => $product,
            'categories' => Category::orderBy('sort_order')->get(),
            'collections' => Collection::orderBy('sort_order')->get(),
        ];
    }

    /** @return array<string, mixed> */
    private function attributes(ProductRequest $request): array
    {
        return $request->safe()->except(['image', 'gallery', 'remove_gallery', 'published']);
    }

    /**
     * @param  list<string>  $existing
     * @return list<string>
     */
    private function storeGallery(ProductRequest $request, array $existing): array
    {
        foreach ($request->file('gallery', []) as $file) {
            $existing[] = $file->store('products', 'public');
        }

        return array_slice($existing, 0, 8);
    }
}
