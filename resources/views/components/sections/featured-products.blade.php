{{--
    Sorotan produk: beberapa produk pilihan agar pengunjung cepat tertarik.
    `$products` boleh berisi model Product yang belum tersimpan (kartu tiruan);
    x-product-card menangani tautannya.
--}}
@props(['products', 'title' => 'Pilihan Harnid', 'eyebrow' => 'Sorotan produk'])
@if ($products->isNotEmpty())
    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6" aria-labelledby="featured-title">
        <div class="flex items-end justify-between gap-4">
            <div>
                <p class="eyebrow">{{ $eyebrow }}</p>
                <h2 id="featured-title" class="mt-2 font-display text-3xl font-medium">{{ $title }}</h2>
            </div>
            <a href="{{ route('catalog.index') }}" class="btn-link shrink-0">Lihat semua</a>
        </div>
        <div class="mt-8 grid grid-cols-2 gap-x-4 gap-y-10 md:grid-cols-4">
            @foreach ($products as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </section>
@endif
