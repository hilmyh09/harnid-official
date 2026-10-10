<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * Menjaga kolom produk yang dibutuhkan homepage (sorotan) dan katalog
 * sesuai PRD tetap ada setelah migrasi.
 */
class ProductSchemaTest extends TestCase
{
    use RefreshDatabase;

    public function test_products_table_has_columns_required_by_prd(): void
    {
        $this->assertTrue(Schema::hasTable('categories'));
        $this->assertTrue(Schema::hasColumns('categories', ['id', 'name', 'slug']));

        $this->assertTrue(Schema::hasTable('products'));
        $this->assertTrue(Schema::hasColumns('products', [
            'id', 'name', 'slug', 'description', 'price', 'image_path', 'gallery',
            'category_id', 'is_featured', 'is_active', 'stock', 'published_at', 'created_at',
        ]));
    }

    public function test_products_table_has_featured_index(): void
    {
        $this->assertTrue(Schema::hasIndex('products', 'products_featured_index'));
    }
}
