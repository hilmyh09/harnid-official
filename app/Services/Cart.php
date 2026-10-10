<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Collection;

/**
 * Keranjang berbasis session. Baris keranjang dikunci oleh produk + ukuran.
 */
class Cart
{
    private const KEY = 'cart.items';

    public function __construct(private readonly Session $session) {}

    /** @return array<string, array{product_id:int, size:?string, quantity:int}> */
    public function raw(): array
    {
        return $this->session->get(self::KEY, []);
    }

    public function add(Product $product, ?string $size, int $quantity): void
    {
        $items = $this->raw();
        $key = $this->key($product->id, $size);
        $current = $items[$key]['quantity'] ?? 0;

        $items[$key] = [
            'product_id' => $product->id,
            'size' => $size ?: null,
            'quantity' => min($current + $quantity, 99),
        ];

        $this->session->put(self::KEY, $items);
    }

    public function update(string $key, int $quantity): void
    {
        $items = $this->raw();

        if (! isset($items[$key])) {
            return;
        }

        if ($quantity <= 0) {
            unset($items[$key]);
        } else {
            $items[$key]['quantity'] = min($quantity, 99);
        }

        $this->session->put(self::KEY, $items);
    }

    public function remove(string $key): void
    {
        $this->update($key, 0);
    }

    public function clear(): void
    {
        $this->session->forget(self::KEY);
    }

    public function count(): int
    {
        return array_sum(array_column($this->raw(), 'quantity'));
    }

    /**
     * Baris keranjang beserta produk yang masih dipublikasikan.
     * Produk yang sudah tidak tersedia dibuang dari session.
     *
     * @return Collection<string, array{key:string, product:Product, size:?string, quantity:int, line_total:int}>
     */
    public function lines(): Collection
    {
        $items = $this->raw();

        if ($items === []) {
            return collect();
        }

        $products = Product::published()
            ->whereIn('id', array_column($items, 'product_id'))
            ->get()
            ->keyBy('id');

        $lines = collect();
        $dirty = false;

        foreach ($items as $key => $item) {
            $product = $products->get($item['product_id']);

            if ($product === null) {
                unset($items[$key]);
                $dirty = true;

                continue;
            }

            $lines->put($key, [
                'key' => $key,
                'product' => $product,
                'size' => $item['size'],
                'quantity' => $item['quantity'],
                'line_total' => $product->price * $item['quantity'],
            ]);
        }

        if ($dirty) {
            $this->session->put(self::KEY, $items);
        }

        return $lines;
    }

    public function subtotal(): int
    {
        return (int) $this->lines()->sum('line_total');
    }

    private function key(int $productId, ?string $size): string
    {
        return $productId.':'.($size ?: '-');
    }
}
