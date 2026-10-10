<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Katalog awal Harnid Official. Nama produk, harga, dan gambar adalah CONTOH
 * untuk diganti lewat admin; struktur kategori mengikuti toko modest fashion.
 */
class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        $categories = collect([
            ['Scarves', 'Hijab dan scarf dengan bahan jatuh dan nyaman.'],
            ['Dresses', 'Gamis dan dress untuk kasual sampai formal.'],
            ['Tops', 'Tunik, blus, dan atasan serbaguna.'],
            ['Outerwear', 'Outer, cardigan, dan vest pelengkap gaya.'],
            ['Bottoms', 'Rok dan celana longgar yang anggun.'],
            ['Sets', 'Setelan siap pakai, padu padan tanpa repot.'],
        ])->mapWithKeys(fn ($c, $i) => [$c[0] => Category::updateOrCreate(
            ['slug' => Str::slug($c[0])],
            ['name' => $c[0], 'description' => $c[1], 'sort_order' => $i]
        )]);

        $collections = collect([
            ['Harnid Noir', 'Lini signature Harnid: siluet tegas, detail halus, palet gelap yang mewah.', true, 0],
            ['Timeless Raya', 'Koleksi hari raya dengan warna lembut dan bordir ringan.', false, 1],
            ['Everyday Ease', 'Pilihan harian yang ringan, adem, dan mudah dipadukan.', false, 2],
        ])->mapWithKeys(fn ($c) => [$c[0] => Collection::updateOrCreate(
            ['slug' => Str::slug($c[0])],
            ['name' => $c[0], 'description' => $c[1], 'is_featured' => $c[2], 'sort_order' => $c[3]]
        )]);

        $products = [
            // [nama, kategori, koleksi, harga, harga coret, warna, hex, ukuran, stok, gambar, featured]
            ['Aira Voile Scarf', 'Scarves', 'Everyday Ease', 149000, null, 'Sand', '#d9c3a5', null, 40, 'scarf-sand', false],
            ['Aira Voile Scarf Olive', 'Scarves', 'Everyday Ease', 149000, null, 'Olive', '#8a9a6b', null, 35, 'scarf-olive', false],
            ['Noir Satin Scarf', 'Scarves', 'Harnid Noir', 229000, null, 'Noir', '#2b2b2b', null, 25, 'scarf-noir', true],
            ['Kirana Flowy Dress', 'Dresses', 'Timeless Raya', 589000, 689000, 'Ivory', '#efe6d8', ['S', 'M', 'L', 'XL'], 18, 'dress-ivory', true],
            ['Raya Embroidered Dress', 'Dresses', 'Timeless Raya', 749000, null, 'Maroon', '#7a2e3a', ['S', 'M', 'L', 'XL'], 12, 'dress-maroon', false],
            ['Lavia Pleated Dress', 'Dresses', 'Everyday Ease', 499000, null, 'Navy', '#2c3a5a', ['S', 'M', 'L', 'XL'], 20, 'dress-navy', false],
            ['Noir Structured Dress', 'Dresses', 'Harnid Noir', 899000, null, 'Noir', '#262626', ['S', 'M', 'L'], 8, 'dress-noir', true],
            ['Sora Cotton Tunic', 'Tops', 'Everyday Ease', 329000, 379000, 'Cream', '#f1e9dc', ['S', 'M', 'L', 'XL'], 30, 'top-cream', false],
            ['Mira Linen Blouse', 'Tops', 'Everyday Ease', 299000, null, 'Sage', '#b7c4ad', ['S', 'M', 'L', 'XL'], 22, 'top-sage', false],
            ['Hana Long Outer', 'Outerwear', 'Everyday Ease', 459000, null, 'Camel', '#c69c6d', ['S', 'M', 'L'], 15, 'outer-camel', false],
            ['Noir Tailored Vest', 'Outerwear', 'Harnid Noir', 549000, null, 'Noir', '#2a2a2a', ['S', 'M', 'L'], 10, 'outer-noir', false],
            ['Wide Leg Pants', 'Bottoms', 'Everyday Ease', 279000, null, 'Black', '#2e2e2e', ['S', 'M', 'L', 'XL'], 28, 'bottom-black', false],
            ['A-Line Pleated Skirt', 'Bottoms', 'Everyday Ease', 319000, null, 'Stone', '#b9b1a3', ['S', 'M', 'L', 'XL'], 16, 'bottom-stone', false],
            ['Dara Two-Piece Set', 'Sets', 'Timeless Raya', 659000, 759000, 'Dusty Pink', '#c99a9a', ['S', 'M', 'L', 'XL'], 14, 'set-dusty', true],
            ['Noir Signature Set', 'Sets', 'Harnid Noir', 1099000, null, 'Noir', '#232323', ['S', 'M', 'L'], 6, 'set-noir', false],
            ['Mocha Knit Set', 'Sets', 'Everyday Ease', 579000, null, 'Mocha', '#8c6a52', ['S', 'M', 'L', 'XL'], 11, 'set-mocha', false],
        ];

        foreach ($products as $i => [$name, $cat, $col, $price, $compare, $color, $hex, $sizes, $stock, $img, $featured]) {
            Product::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'category_id' => $categories[$cat]->id,
                    'collection_id' => $collections[$col]->id,
                    'name' => $name,
                    'sku' => 'HRN-'.str_pad((string) ($i + 1), 4, '0', STR_PAD_LEFT),
                    'price' => $price,
                    'compare_at_price' => $compare,
                    'description' => "{$name} dari koleksi {$col}. Bahan premium yang jatuh dan nyaman dipakai seharian, jahitan rapi, dan warna yang mudah dipadupadankan. Deskripsi ini contoh; ubah lewat admin.",
                    'color' => $color,
                    'color_hex' => $hex,
                    'sizes' => $sizes,
                    'stock' => $stock,
                    'image_path' => "/images/products/{$img}.svg",
                    'is_featured' => $featured,
                    'is_active' => true,
                    'published_at' => now()->subDays(count($products) - $i),
                ]
            );
        }

        $stores = [
            ['Harnid Official Store Kota Kasablanka', 'Jakarta', 'Kota Kasablanka Lt. 2, Jl. Casablanca Raya Kav. 88', '0812-0000-0001'],
            ['Harnid Official Store Grand Indonesia', 'Jakarta', 'Grand Indonesia West Mall Lt. 3, Jl. M.H. Thamrin No. 1', '0812-0000-0002'],
            ['Harnid Official Store Paris Van Java', 'Bandung', 'Paris Van Java Mall, Jl. Sukajadi No. 131-139', '0812-0000-0003'],
            ['Harnid Official Store Pakuwon Mall', 'Surabaya', 'Pakuwon Mall Lt. 1, Jl. Mayjen Yono Suwoyo', '0812-0000-0004'],
            ['Harnid Official Store Hartono Mall', 'Yogyakarta', 'Hartono Mall Lt. 2, Jl. Ring Road Utara', '0812-0000-0005'],
        ];

        foreach ($stores as $i => [$name, $city, $address, $phone]) {
            Store::updateOrCreate(['name' => $name], [
                'city' => $city, 'address' => $address, 'phone' => $phone, 'hours' => '10.00–22.00 WIB', 'sort_order' => $i,
            ]);
        }
    }
}
