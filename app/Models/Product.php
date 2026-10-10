<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'category_id', 'collection_id', 'name', 'slug', 'sku', 'price', 'compare_at_price',
        'description', 'color', 'color_hex', 'sizes', 'stock', 'image_path', 'gallery',
        'is_featured', 'is_active', 'published_at',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'compare_at_price' => 'integer',
            'stock' => 'integer',
            'sizes' => 'array',
            'gallery' => 'array',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function collection(): BelongsTo
    {
        return $this->belongsTo(Collection::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /** Produk yang boleh tampil di toko. */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_active', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /** Produk sorotan homepage: tayang, ditandai unggulan, terbaru dulu. */
    public function scopeFeaturedForHome(Builder $query): Builder
    {
        return $query->published()->with('category')->where('is_featured', true)->latest('published_at');
    }

    public function isPublished(): bool
    {
        return $this->is_active && $this->published_at !== null && $this->published_at->lte(now());
    }

    public function hasSizes(): bool
    {
        return ! empty($this->sizes);
    }

    public function hasSize(?string $size): bool
    {
        if (! $this->hasSizes()) {
            return $size === null || $size === '';
        }

        return in_array($size, $this->sizes, true);
    }

    public function isOnSale(): bool
    {
        return $this->compare_at_price !== null && $this->compare_at_price > $this->price;
    }

    public function discountPercent(): int
    {
        if (! $this->isOnSale()) {
            return 0;
        }

        return (int) round((1 - $this->price / $this->compare_at_price) * 100);
    }

    public function imageUrl(): ?string
    {
        return $this->image_path === null ? null : self::resolveImageUrl($this->image_path);
    }

    /** @return list<string> URL gambar tambahan (tanpa gambar utama). */
    public function galleryUrls(): array
    {
        return array_values(array_map(self::resolveImageUrl(...), $this->gallery ?? []));
    }

    /** @return list<string> Gambar utama diikuti galeri. */
    public function allImageUrls(): array
    {
        return array_values(array_filter([$this->imageUrl(), ...$this->galleryUrls()]));
    }

    public static function resolveImageUrl(string $path): string
    {
        if (str_starts_with($path, 'http') || str_starts_with($path, '/')) {
            return $path;
        }

        return Storage::disk('public')->url($path);
    }
}
