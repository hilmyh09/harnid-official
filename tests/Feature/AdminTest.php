<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_pages_require_login(): void
    {
        $product = Product::factory()->create();
        $order = Order::factory()->create();

        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
        $this->get(route('admin.products.index'))->assertRedirect(route('login'));
        $this->get(route('admin.orders.show', $order))->assertRedirect(route('login'));
        $this->patch(route('admin.orders.status', $order), ['status' => 'confirmed'])->assertRedirect(route('login'));
        $this->put(route('admin.products.update', $product), ['name' => 'Hack'])->assertRedirect(route('login'));

        $this->assertSame('pending', $order->fresh()->status);
    }

    public function test_dashboard_shows_summary(): void
    {
        Order::factory()->create(['status' => 'pending', 'total' => 100000]);
        Order::factory()->create(['status' => 'confirmed', 'total' => 250000]);
        Product::factory()->create(['stock' => 2]);
        ContactMessage::factory()->create();

        $this->actingAs(User::factory()->create())
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Rp 250.000')
            ->assertSee('Pesanan menunggu');
    }

    public function test_admin_can_create_product_with_image(): void
    {
        Storage::fake('public');
        $category = Category::factory()->create();

        $this->actingAs(User::factory()->create())
            ->post(route('admin.products.store'), [
                'name' => 'Produk Uji Admin',
                'sku' => 'HRN-UJI1',
                'category_id' => $category->id,
                'price' => 199000,
                'stock' => 5,
                'sizes' => 'S, M',
                'published' => 1,
                'is_active' => 1,
                'image' => UploadedFile::fake()->image('foto.jpg', 600, 800),
            ])
            ->assertRedirect(route('admin.products.index'));

        $product = Product::where('sku', 'HRN-UJI1')->firstOrFail();
        $this->assertSame('produk-uji-admin', $product->slug);
        $this->assertSame(['S', 'M'], $product->sizes);
        $this->assertTrue($product->isPublished());
        Storage::disk('public')->assertExists($product->image_path);

        $this->get(route('product.show', $product))->assertOk()->assertSee('Produk Uji Admin');
    }

    public function test_admin_product_validation_and_update(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['price' => 300000]);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), ['name' => '', 'sku' => $product->sku, 'category_id' => $product->category_id, 'price' => 300000, 'compare_at_price' => 100000, 'stock' => 1])
            ->assertSessionHasErrors(['name', 'compare_at_price']);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), ['name' => 'Nama Baru', 'sku' => $product->sku, 'category_id' => $product->category_id, 'price' => 350000, 'stock' => 7, 'is_active' => 1])
            ->assertRedirect(route('admin.products.index'));

        $product->refresh();
        $this->assertSame('Nama Baru', $product->name);
        $this->assertSame(350000, $product->price);
        $this->assertNull($product->published_at, 'tanpa checkbox tayang, produk menjadi draf');
    }

    public function test_admin_destroy_hides_product_instead_of_deleting(): void
    {
        $product = Product::factory()->create();

        $this->actingAs(User::factory()->create())->delete(route('admin.products.destroy', $product))->assertRedirect();

        $this->assertDatabaseHas('products', ['id' => $product->id, 'is_active' => false]);
        $this->get(route('product.show', $product))->assertNotFound();
    }

    public function test_admin_can_view_and_update_order_status(): void
    {
        $order = Order::factory()->create();
        $order->items()->create(['product_name' => 'Kirana Dress', 'sku' => 'HRN-0001', 'size' => 'M', 'unit_price' => 500000, 'quantity' => 1, 'line_total' => 500000]);
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('admin.orders.index', ['status' => 'pending']))->assertOk()->assertSee($order->order_number);
        $this->actingAs($user)->get(route('admin.orders.show', $order))->assertOk()->assertSee('Kirana Dress');

        $this->actingAs($user)->patch(route('admin.orders.status', $order), ['status' => 'bogus'])->assertSessionHasErrors('status');
        $this->actingAs($user)->patch(route('admin.orders.status', $order), ['status' => 'shipped'])->assertRedirect();

        $this->assertSame('shipped', $order->fresh()->status);
    }

    public function test_admin_can_mark_message_read(): void
    {
        $message = ContactMessage::factory()->create();

        $this->actingAs(User::factory()->create())->patch(route('admin.messages.read', $message))->assertRedirect();

        $this->assertNotNull($message->fresh()->read_at);
    }
}
