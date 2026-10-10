<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/** @extends Factory<Product> */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = ucfirst(fake()->unique()->words(2, true));

        return [
            'category_id' => Category::factory(),
            'collection_id' => null,
            'name' => $name,
            'slug' => Str::slug($name).'-'.fake()->unique()->numberBetween(1, 99999),
            'sku' => 'HRN-'.strtoupper(Str::random(6)),
            'price' => fake()->numberBetween(150, 900) * 1000,
            'compare_at_price' => null,
            'description' => fake()->paragraph(),
            'color' => 'Hitam',
            'color_hex' => '#1f1f1f',
            'sizes' => ['S', 'M', 'L', 'XL'],
            'stock' => 10,
            'is_featured' => false,
            'is_active' => true,
            'published_at' => now()->subDay(),
        ];
    }

    public function unpublished(): static
    {
        return $this->state(fn () => ['published_at' => null]);
    }

    public function withoutSizes(): static
    {
        return $this->state(fn () => ['sizes' => null]);
    }
}
