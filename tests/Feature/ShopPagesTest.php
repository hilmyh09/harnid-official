<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShopPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_shows_new_arrivals_categories_and_signature_collection(): void
    {
        $category = Category::factory()->create(['name' => 'Dresses', 'slug' => 'dresses']);
        $collection = Collection::factory()->create(['name' => 'Harnid Noir', 'slug' => 'harnid-noir', 'is_featured' => true]);
        Product::factory()->create(['name' => 'Kirana Dress', 'category_id' => $category->id, 'collection_id' => $collection->id]);
        Store::factory()->count(2)->create(['city' => 'Jakarta']);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('/images/brand/mark-256.png')
            ->assertSee('Kirana Dress')
            ->assertSee('Dresses')
            ->assertSee('Harnid Noir')
            ->assertSee('2 toko, 1 kota');
    }

    public function test_home_sections_render_in_prd_order(): void
    {
        $category = Category::factory()->create(['name' => 'Dresses', 'slug' => 'dresses']);
        Product::factory()->create(['name' => 'Sorotan Dress', 'category_id' => $category->id, 'is_featured' => true]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSeeInOrder([
                'id="hero-title"',
                'Mulai Belanja',
                'id="featured-title"',
                'id="categories-title"',
                'id="new-arrivals-title"',
                'id="benefits-title"',
                '<footer',
            ], false);
    }

    public function test_catalog_hides_unpublished_and_inactive_products(): void
    {
        Product::factory()->create(['name' => 'Tayang Dress']);
        Product::factory()->unpublished()->create(['name' => 'Draf Dress']);
        Product::factory()->create(['name' => 'Nonaktif Dress', 'is_active' => false]);

        $this->get(route('catalog.index'))
            ->assertOk()
            ->assertSee('Tayang Dress')
            ->assertDontSee('Draf Dress')
            ->assertDontSee('Nonaktif Dress');
    }

    public function test_catalog_search_and_sort(): void
    {
        Product::factory()->create(['name' => 'Noir Satin Scarf', 'price' => 229000]);
        Product::factory()->create(['name' => 'Aira Voile Scarf', 'price' => 149000]);

        $this->get(route('catalog.index', ['q' => 'noir']))
            ->assertOk()->assertSee('Noir Satin Scarf')->assertDontSee('Aira Voile Scarf');

        $this->get(route('catalog.index', ['urut' => 'termurah']))
            ->assertOk()->assertSeeInOrder(['Aira Voile Scarf', 'Noir Satin Scarf']);
    }

    public function test_category_collection_sale_and_new_arrival_pages(): void
    {
        $category = Category::factory()->create(['slug' => 'tops']);
        $collection = Collection::factory()->create(['slug' => 'everyday-ease']);
        Product::factory()->create(['name' => 'Sora Tunic', 'category_id' => $category->id, 'collection_id' => $collection->id, 'price' => 329000, 'compare_at_price' => 379000]);
        Product::factory()->create(['name' => 'Lama Dress', 'published_at' => now()->subDays(90)]);

        $this->get(route('catalog.category', $category))->assertOk()->assertSee('Sora Tunic')->assertDontSee('Lama Dress');
        $this->get(route('catalog.collection', $collection))->assertOk()->assertSee('Sora Tunic');
        $this->get(route('catalog.sale'))->assertOk()->assertSee('Sora Tunic')->assertDontSee('Lama Dress')->assertSee('-13%');
        $this->get(route('catalog.new'))->assertOk()->assertSee('Sora Tunic')->assertDontSee('Lama Dress');
        $this->get('/kategori/tidak-ada')->assertNotFound();
    }

    public function test_product_page_renders_and_unpublished_is_404(): void
    {
        $product = Product::factory()->create(['name' => 'Kirana Dress', 'price' => 589000]);
        $draft = Product::factory()->unpublished()->create();

        $this->get(route('product.show', $product))->assertOk()->assertSee('Kirana Dress')->assertSee('Rp 589.000')->assertSee('Tambah ke Bag');
        $this->get(route('product.show', $draft))->assertNotFound();
    }

    public function test_static_pages_render(): void
    {
        Store::factory()->create(['name' => 'Harnid Store Bandung', 'city' => 'Bandung']);

        $this->get(route('about'))->assertOk()->assertSee('Tentang');
        $this->get(route('stores'))->assertOk()->assertSee('Harnid Store Bandung')->assertSee('Bandung');
        $this->get(route('size-guide'))->assertOk()->assertSee('Panduan ukuran');
        $this->get(route('contact'))->assertOk()->assertSee('Kirim pesan');
    }
}
