<x-layouts.shop :title="$title" :description="$subtitle">
    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6">
        <nav class="text-xs text-noir-700/70" aria-label="Breadcrumb"><a href="{{ route('home') }}" class="hover:underline">Beranda</a> / <span>{{ $title }}</span></nav>
        <h1 class="mt-3 font-display text-4xl font-medium">{{ $title }}</h1>
        @if ($subtitle)<p class="mt-2 max-w-xl text-sm text-noir-700">{{ $subtitle }}</p>@endif

        <div class="mt-8 flex flex-col gap-6 lg:flex-row">
            <aside class="lg:w-56 lg:shrink-0">
                <p class="eyebrow">Kategori</p>
                <ul class="mt-3 space-y-2 text-sm">
                    <li><a href="{{ route('catalog.index') }}" class="{{ request()->routeIs('catalog.index') ? 'font-semibold text-noir-900' : 'text-noir-700 hover:text-noir-900' }}">Semua produk</a></li>
                    @foreach ($categories as $category)
                        <li><a href="{{ route('catalog.category', $category) }}" class="{{ $activeCategory?->is($category) ? 'font-semibold text-noir-900' : 'text-noir-700 hover:text-noir-900' }}">{{ $category->name }}</a></li>
                    @endforeach
                </ul>
            </aside>

            <div class="flex-1">
                <form method="GET" class="mb-6 flex flex-wrap items-center gap-3 border-b border-ivory-200 pb-4">
                    <label for="q" class="sr-only">Cari</label>
                    <input id="q" name="q" type="search" value="{{ $search }}" placeholder="Cari produk atau SKU" class="input max-w-xs">
                    <label for="urut" class="sr-only">Urutkan</label>
                    <select id="urut" name="urut" class="input max-w-[11rem]">
                        <option value="terbaru" @selected($sort === 'terbaru')>Terbaru</option>
                        <option value="termurah" @selected($sort === 'termurah')>Harga terendah</option>
                        <option value="termahal" @selected($sort === 'termahal')>Harga tertinggi</option>
                    </select>
                    <button type="submit" class="btn-secondary py-2.5">Terapkan</button>
                    <span class="ml-auto text-xs text-noir-700/70">{{ $products->total() }} produk</span>
                </form>

                <div class="grid grid-cols-2 gap-x-4 gap-y-10 md:grid-cols-3">
                    @forelse ($products as $product)
                        <x-product-card :product="$product" />
                    @empty
                        <p class="col-span-full py-10 text-center text-sm text-noir-700">Tidak ada produk yang cocok.</p>
                    @endforelse
                </div>
                <div class="mt-10">{{ $products->links() }}</div>
            </div>
        </div>
    </section>
</x-layouts.shop>
