<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartCheckoutTest extends TestCase
{
    use RefreshDatabase;

    private function customer(array $overrides = []): array
    {
        return array_merge([
            'customer_name' => 'Siti Uji',
            'customer_phone' => '081234567890',
            'customer_email' => 'siti@example.com',
            'address' => 'Jl. Mawar No. 1',
            'city' => 'Depok',
            'province' => 'Jawa Barat',
            'postal_code' => '16411',
        ], $overrides);
    }

    public function test_add_to_cart_requires_size_when_product_has_sizes(): void
    {
        $product = Product::factory()->create();

        $this->post(route('cart.add', $product), ['quantity' => 1])->assertSessionHasErrors('size');
        $this->post(route('cart.add', $product), ['size' => 'XXL', 'quantity' => 1])->assertSessionHasErrors('size');

        $this->get(route('cart.index'))->assertSee('masih kosong');
    }

    public function test_cart_count_endpoint_reflects_session_cart(): void
    {
        $dress = Product::factory()->create(['price' => 100000]);
        $scarf = Product::factory()->withoutSizes()->create(['price' => 25000]);

        $this->getJson(route('cart.count'))
            ->assertOk()
            ->assertHeader('Cache-Control', 'no-store, private')
            ->assertExactJson(['count' => 0, 'lines' => 0, 'subtotal' => 0, 'subtotal_formatted' => 'Rp 0']);

        $this->post(route('cart.add', $dress), ['size' => 'M', 'quantity' => 2]);
        $this->post(route('cart.add', $scarf), ['quantity' => 1]);

        $this->getJson(route('cart.count'))
            ->assertOk()
            ->assertJson(['count' => 3, 'lines' => 2, 'subtotal' => 225000, 'subtotal_formatted' => 'Rp 225.000']);
    }

    public function test_add_update_and_remove_cart_lines(): void
    {
        $dress = Product::factory()->create(['name' => 'Kirana Dress', 'price' => 500000]);
        $scarf = Product::factory()->withoutSizes()->create(['name' => 'Aira Scarf', 'price' => 150000]);

        $this->post(route('cart.add', $dress), ['size' => 'M', 'quantity' => 2])->assertRedirect(route('cart.index'));
        $this->post(route('cart.add', $dress), ['size' => 'M', 'quantity' => 1]); // digabung ke baris yang sama
        $this->post(route('cart.add', $scarf), ['quantity' => 1]);

        $this->get(route('cart.index'))->assertOk()
            ->assertSee('Kirana Dress')->assertSee('Aira Scarf')
            ->assertSee('Rp 1.500.000')   // 3 x 500.000
            ->assertSee('Rp 1.650.000');  // subtotal

        $this->patch(route('cart.update', $dress->id.':M'), ['quantity' => 1]);
        $this->get(route('cart.index'))->assertSee('Rp 650.000');

        $this->delete(route('cart.remove', $scarf->id.':-'));
        $this->get(route('cart.index'))->assertDontSee('Aira Scarf')->assertSee('Rp 500.000');
    }

    public function test_unpublished_product_cannot_be_added_and_is_dropped_from_cart(): void
    {
        $product = Product::factory()->withoutSizes()->create();
        $this->post(route('cart.add', $product), ['quantity' => 1]);

        $product->update(['is_active' => false]);

        $this->get(route('cart.index'))->assertSee('masih kosong');
        $this->post(route('cart.add', $product), ['quantity' => 1])->assertNotFound();
    }

    public function test_checkout_creates_order_reduces_stock_and_clears_cart(): void
    {
        $product = Product::factory()->create(['name' => 'Kirana Dress', 'price' => 500000, 'stock' => 5]);
        $this->post(route('cart.add', $product), ['size' => 'L', 'quantity' => 2]);

        $this->get(route('checkout.show'))->assertOk()->assertSee('Kirana Dress');

        $response = $this->post(route('checkout.store'), $this->customer());

        $order = Order::with('items')->firstOrFail();
        $response->assertRedirect(route('checkout.success', $order));

        $this->assertSame(1000000, $order->total);
        $this->assertSame('pending', $order->status);
        $this->assertCount(1, $order->items);
        $this->assertSame('L', $order->items[0]->size);
        $this->assertSame(2, $order->items[0]->quantity);
        $this->assertSame(3, $product->fresh()->stock);
        $this->assertStringStartsWith('HRN-', $order->order_number);

        $this->get(route('checkout.success', $order))->assertOk()
            ->assertSee($order->order_number)->assertSee('wa.me/')->assertSee('Rp 1.000.000');

        $this->get(route('cart.index'))->assertSee('masih kosong');
    }

    public function test_checkout_rejects_order_when_stock_is_insufficient(): void
    {
        $product = Product::factory()->create(['stock' => 1]);
        $this->post(route('cart.add', $product), ['size' => 'M', 'quantity' => 2]);

        $this->post(route('checkout.store'), $this->customer())
            ->assertRedirect(route('cart.index'))
            ->assertSessionHasErrors('cart');

        $this->assertSame(0, Order::count());
        $this->assertSame(1, $product->fresh()->stock);
    }

    public function test_checkout_validates_customer_data_and_empty_cart(): void
    {
        $this->get(route('checkout.show'))->assertRedirect(route('cart.index'));

        $product = Product::factory()->withoutSizes()->create();
        $this->post(route('cart.add', $product), ['quantity' => 1]);

        $this->post(route('checkout.store'), $this->customer(['customer_phone' => 'abc', 'address' => '']))
            ->assertSessionHasErrors(['customer_phone', 'address']);

        $this->assertSame(0, Order::count());
    }

    public function test_success_page_is_not_accessible_from_another_session(): void
    {
        $order = Order::factory()->create();

        $this->get(route('checkout.success', $order))->assertNotFound();
    }
}
