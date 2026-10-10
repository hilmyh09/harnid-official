{{-- Kategori: pintasan ke katalog per kategori. --}}
@props(['categories'])
<section class="mx-auto max-w-7xl px-4 pt-16 sm:px-6" aria-labelledby="categories-title">
    <div class="flex items-end justify-between">
        <div>
            <p class="eyebrow">Shop by category</p>
            <h2 id="categories-title" class="mt-2 font-display text-3xl font-medium">Kategori</h2>
        </div>
        <a href="{{ route('catalog.index') }}" class="btn-link">Lihat semua</a>
    </div>
    <div class="mt-8 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">
        @foreach ($categories as $category)
            <a href="{{ route('catalog.category', $category) }}" class="group border border-ivory-200 bg-white p-5 text-center transition hover:border-noir-900">
                <p class="font-display text-xl font-medium text-noir-900">{{ $category->name }}</p>
                <p class="mt-1 text-[11px] uppercase tracking-widest text-noir-700/60 group-hover:text-gold-600">Lihat</p>
            </a>
        @endforeach
    </div>
</section>
