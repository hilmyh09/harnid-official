{{-- New arrivals: produk yang baru tayang. --}}
@props(['products'])
<section class="mx-auto max-w-7xl px-4 py-8 sm:px-6" aria-labelledby="new-arrivals-title">
    <div class="flex items-end justify-between">
        <div>
            <p class="eyebrow">Just dropped</p>
            <h2 id="new-arrivals-title" class="mt-2 font-display text-3xl font-medium">New Arrivals</h2>
        </div>
        <a href="{{ route('catalog.new') }}" class="btn-link">Semua rilisan baru</a>
    </div>
    <div class="mt-8 grid grid-cols-2 gap-x-4 gap-y-10 md:grid-cols-4">
        @forelse ($products as $product)
            <x-product-card :product="$product" />
        @empty
            <p class="col-span-full text-sm text-noir-700">Belum ada produk.</p>
        @endforelse
    </div>
</section>
