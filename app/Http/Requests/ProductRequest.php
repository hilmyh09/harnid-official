<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    protected function prepareForValidation(): void
    {
        $sizes = $this->input('sizes');

        if (is_string($sizes)) {
            $sizes = array_values(array_filter(array_map('trim', explode(',', $sizes))));
        }

        $this->merge([
            'sizes' => $sizes ?: null,
            'slug' => Str::slug($this->input('slug') ?: $this->input('name', '')),
            'is_featured' => $this->boolean('is_featured'),
            'is_active' => $this->boolean('is_active'),
        ]);
    }

    public function rules(): array
    {
        $id = $this->route('product')?->id;

        return [
            'name' => ['required', 'string', 'max:150'],
            'slug' => ['required', 'string', 'max:170', Rule::unique('products', 'slug')->ignore($id)],
            'sku' => ['required', 'string', 'max:40', Rule::unique('products', 'sku')->ignore($id)],
            'category_id' => ['required', 'exists:categories,id'],
            'collection_id' => ['nullable', 'exists:collections,id'],
            'price' => ['required', 'integer', 'min:0', 'max:999999999'],
            'compare_at_price' => ['nullable', 'integer', 'min:0', 'max:999999999', 'gt:price'],
            'description' => ['nullable', 'string', 'max:5000'],
            'color' => ['nullable', 'string', 'max:60'],
            'color_hex' => ['nullable', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'sizes' => ['nullable', 'array', 'max:10'],
            'sizes.*' => ['string', 'max:10'],
            'stock' => ['required', 'integer', 'min:0', 'max:999999'],
            'image' => ['nullable', 'image', 'max:3072'],
            'gallery' => ['nullable', 'array', 'max:8'],
            'gallery.*' => ['image', 'max:3072'],
            'remove_gallery' => ['nullable', 'array'],
            'remove_gallery.*' => ['string'],
            'is_featured' => ['boolean'],
            'is_active' => ['boolean'],
            'published' => ['nullable', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nama produk', 'sku' => 'SKU', 'category_id' => 'kategori', 'collection_id' => 'koleksi',
            'price' => 'harga', 'compare_at_price' => 'harga coret', 'stock' => 'stok', 'image' => 'gambar', 'gallery' => 'galeri',
        ];
    }
}
