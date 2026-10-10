<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddToCartRequest;
use App\Models\Product;
use App\Services\Cart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(private readonly Cart $cart) {}

    public function index(): View
    {
        return view('shop.cart', [
            'lines' => $this->cart->lines(),
            'subtotal' => $this->cart->subtotal(),
        ]);
    }

    public function add(AddToCartRequest $request, Product $product): RedirectResponse
    {
        abort_unless($product->isPublished(), 404);

        $size = $request->input('size');

        if (! $product->hasSize($size)) {
            return back()->withErrors(['size' => 'Pilih ukuran terlebih dahulu.'])->withInput();
        }

        if ($product->stock < 1) {
            return back()->withErrors(['quantity' => 'Stok produk ini sedang kosong.']);
        }

        $this->cart->add($product, $size, (int) $request->integer('quantity', 1));

        return redirect()->route('cart.index')->with('status', "{$product->name} ditambahkan ke keranjang.");
    }

    public function update(Request $request, string $key): RedirectResponse
    {
        $data = $request->validate(['quantity' => ['required', 'integer', 'min:0', 'max:99']]);

        $this->cart->update($key, (int) $data['quantity']);

        return redirect()->route('cart.index');
    }

    public function remove(string $key): RedirectResponse
    {
        $this->cart->remove($key);

        return redirect()->route('cart.index')->with('status', 'Produk dihapus dari keranjang.');
    }
}
