<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeaturedProductApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_returns_featured_published_products_as_json(): void
    {
        $category = Category::factory()->create(['name' => 'Dresses', 'slug' => 'dresses']);
        $featured = Product::factory()->create(['name' => 'Kirana Dress', 'price' => 589000, 'compare_at_price' => 689000, 'is_featured' => true, 'category_id' => $category->id, 'image_path' => '/images/products/dress-ivory.svg']);
        Product::factory()->create(['name' => 'Biasa Dress', 'is_featured' => false]);
        Product::factory()->unpublished()->create(['name' => 'Draf Dress', 'is_featured' => true]);
        Product::factory()->create(['name' => 'Nonaktif Dress', 'is_featured' => true, 'is_active' => false]);

        $this->getJson('/api/produk/unggulan')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.name', 'Kirana Dress')
            ->assertJsonPath('data.0.slug', $featured->slug)
            ->assertJsonPath('data.0.price', 589000)
            ->assertJsonPath('data.0.price_formatted', 'Rp 589.000')
            ->assertJsonPath('data.0.is_on_sale', true)
            ->assertJsonPath('data.0.discount_percent', 15)
            ->assertJsonPath('data.0.image_url', '/images/products/dress-ivory.svg')
            ->assertJsonPath('data.0.category.slug', 'dresses')
            ->assertJsonPath('data.0.url', route('product.show', $featured))
            ->assertJsonMissing(['name' => 'Biasa Dress'])
            ->assertJsonMissing(['name' => 'Draf Dress'])
            ->assertJsonMissing(['name' => 'Nonaktif Dress']);
    }

    public function test_falls_back_to_latest_products_and_respects_limit(): void
    {
        Product::factory()->count(6)->create(['is_featured' => false]);

        $this->getJson('/api/produk/unggulan')->assertOk()->assertJsonCount(4, 'data');
        $this->getJson('/api/produk/unggulan?limit=2')->assertOk()->assertJsonCount(2, 'data');
        $this->getJson('/api/produk/unggulan?limit=99')->assertOk()->assertJsonCount(6, 'data');
    }

    public function test_returns_empty_list_when_catalog_is_empty(): void
    {
        $this->getJson('/api/produk/unggulan')->assertOk()->assertExactJson(['data' => []]);
    }
}
