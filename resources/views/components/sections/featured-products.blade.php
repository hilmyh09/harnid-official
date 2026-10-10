{{-- Sorotan produk: beberapa produk pilihan agar pengunjung cepat tertarik. --}}
@props(['products'])
@if ($products->isNotEmpty())
    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6" aria-labelledby="featured-title">
        <p class="eyebrow">Editor's pick</p>
        <h2 id="featured-title" class="mt-2 font-display text-3xl font-medium">Pilihan Harnid</h2>
        <div class="mt-8 grid grid-cols-2 gap-x-4 gap-y-10 md:grid-cols-4">
            @foreach ($products as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </section>
@endif
