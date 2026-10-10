<x-layouts.shop>
    {{-- Hero --}}
    <section class="bg-ivory-100">
        <div class="mx-auto grid max-w-7xl items-center gap-10 px-4 py-14 sm:px-6 md:grid-cols-2 md:py-20">
            <div class="order-2 md:order-1">
                <p class="eyebrow">Koleksi terbaru</p>
                <h1 class="mt-4 max-w-xl font-display text-5xl font-medium leading-[1.05] text-noir-900 sm:text-6xl">
                    Anggun di setiap<br>momen Anda.
                </h1>
                <p class="mt-5 max-w-md text-sm text-noir-700 sm:text-base">{{ config('company.tagline') }}. Ready-to-wear untuk kasual hingga formal.</p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('catalog.new') }}" class="btn-primary">Belanja New Arrivals</a>
                    <a href="{{ route('catalog.index') }}" class="btn-secondary">Semua produk</a>
                </div>
            </div>
            <div class="order-1 aspect-[4/5] overflow-hidden bg-ivory-200 md:order-2">
                <img src="/images/campaign/hero.jpg" alt="Tiga model mengenakan Harnid Basic Shirt warna cokelat, abu-abu, dan hitam" class="h-full w-full object-cover object-top" fetchpriority="high">
            </div>
        </div>
    </section>

    {{-- Kategori --}}
    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6">
        <div class="flex items-end justify-between">
            <div>
                <p class="eyebrow">Shop by category</p>
                <h2 class="mt-2 font-display text-3xl font-medium">Kategori</h2>
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

    {{-- New arrivals --}}
    <section class="mx-auto max-w-7xl px-4 py-8 sm:px-6">
        <div class="flex items-end justify-between">
            <div>
                <p class="eyebrow">Just dropped</p>
                <h2 class="mt-2 font-display text-3xl font-medium">New Arrivals</h2>
            </div>
            <a href="{{ route('catalog.new') }}" class="btn-link">Semua rilisan baru</a>
        </div>
        <div class="mt-8 grid grid-cols-2 gap-x-4 gap-y-10 md:grid-cols-4">
            @forelse ($newArrivals as $product)
                <x-product-card :product="$product" />
            @empty
                <p class="col-span-full text-sm text-noir-700">Belum ada produk.</p>
            @endforelse
        </div>
    </section>

    {{-- Signature line --}}
    @if ($featuredCollection)
        <section class="mt-16 bg-noir-900 text-ivory-50">
            <div class="mx-auto grid max-w-7xl items-center gap-10 px-4 py-20 sm:px-6 md:grid-cols-2">
                <div class="order-2 md:order-1">
                    <p class="eyebrow text-gold-400">Signature line</p>
                    <h2 class="mt-3 font-display text-4xl font-medium sm:text-5xl">{{ $featuredCollection->name }}</h2>
                    <p class="mt-5 max-w-md text-sm leading-relaxed text-ivory-200">{{ $featuredCollection->description }}</p>
                    <a href="{{ route('catalog.collection', $featuredCollection) }}" class="btn-primary mt-8 bg-gold-500 text-noir-900 hover:bg-gold-400">Jelajahi {{ $featuredCollection->name }}</a>
                </div>
                <div class="order-1 aspect-[4/3] overflow-hidden md:order-2">
                    <img src="/images/campaign/noir.jpg" alt="{{ $featuredCollection->name }}" class="h-full w-full object-cover object-top" loading="lazy">
                </div>
            </div>
        </section>
    @endif

    {{-- Pilihan editor --}}
    @if ($featuredProducts->isNotEmpty())
        <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6">
            <p class="eyebrow">Editor's pick</p>
            <h2 class="mt-2 font-display text-3xl font-medium">Pilihan Harnid</h2>
            <div class="mt-8 grid grid-cols-2 gap-x-4 gap-y-10 md:grid-cols-4">
                @foreach ($featuredProducts as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </section>
    @endif

    {{-- Lookbook --}}
    <section class="mx-auto max-w-7xl px-4 pb-16 sm:px-6">
        <div class="grid items-center gap-8 md:grid-cols-5">
            <div class="aspect-[4/3] overflow-hidden bg-ivory-200 md:col-span-3">
                <img src="/images/campaign/trio-close.jpg" alt="Harnid Basic Shirt dalam tiga warna" class="h-full w-full object-cover" loading="lazy">
            </div>
            <div class="md:col-span-2">
                <p class="eyebrow">Lookbook</p>
                <h2 class="mt-2 font-display text-3xl font-medium">Satu kemeja, tiga karakter</h2>
                <p class="mt-4 text-sm leading-relaxed text-noir-700">Harnid Basic Shirt hadir dalam Cokelat, Abu-abu, dan Hitam. Potongan relaxed dengan manset lebar yang rapi, cocok dipadukan dengan celana putih untuk tampilan bersih sehari-hari.</p>
                <a href="{{ route('catalog.category', 'tops') }}" class="btn-link mt-6">Lihat semua Tops</a>
            </div>
        </div>
    </section>

    {{-- Keunggulan + toko --}}
    <section class="border-y border-ivory-200 bg-ivory-100">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 py-12 sm:px-6 md:grid-cols-4">
            <div><p class="font-display text-2xl">Bahan premium</p><p class="mt-1 text-sm text-noir-700">Dipilih untuk nyaman dipakai seharian.</p></div>
            <div><p class="font-display text-2xl">Worldwide shipping</p><p class="mt-1 text-sm text-noir-700">Kirim ke seluruh Indonesia dan luar negeri.</p></div>
            <div><p class="font-display text-2xl">Tukar ukuran</p><p class="mt-1 text-sm text-noir-700">Penukaran ukuran dalam 7 hari.*</p></div>
            <div><p class="font-display text-2xl">{{ $storeCount }} toko, {{ $cityCount }} kota</p><p class="mt-1 text-sm text-noir-700"><a href="{{ route('stores') }}" class="underline underline-offset-4">Lihat lokasi toko</a></p></div>
        </div>
    </section>
</x-layouts.shop>
