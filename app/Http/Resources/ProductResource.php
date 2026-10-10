<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Product */
class ProductResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'price' => $this->price,
            'price_formatted' => rupiah($this->price),
            'compare_at_price' => $this->compare_at_price,
            'is_on_sale' => $this->isOnSale(),
            'discount_percent' => $this->discountPercent(),
            'image_url' => $this->imageUrl(),
            'stock' => $this->stock,
            'is_featured' => $this->is_featured,
            'category' => $this->whenLoaded('category', fn () => [
                'name' => $this->category->name,
                'slug' => $this->category->slug,
            ]),
            'url' => route('product.show', $this->resource),
            'published_at' => $this->published_at?->toIso8601String(),
        ];
    }
}
