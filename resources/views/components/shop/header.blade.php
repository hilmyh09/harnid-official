@php($cartCount = app(\App\Services\Cart::class)->count())
@php($categories = \App\Models\Category::orderBy('sort_order')->get(['name', 'slug']))
<div class="bg-noir-900 text-center text-[11px] font-medium uppercase tracking-[0.2em] text-ivory-200">
    <p class="px-4 py-2">Gratis ongkir Jabodetabek &middot; Pengiriman ke seluruh Indonesia &amp; worldwide</p>
</div>
<header class="sticky top-0 z-30 border-b border-ivory-200 bg-ivory-50/95 backdrop-blur">
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-4 sm:px-6">
        <nav class="hidden items-center gap-6 text-xs font-semibold uppercase tracking-[0.18em] lg:flex" aria-label="Navigasi utama">
            <a href="{{ route('catalog.new') }}" class="hover:text-gold-600 {{ request()->routeIs('catalog.new') ? 'text-gold-600' : '' }}">New Arrivals</a>
            <details class="group relative">
                <summary class="cursor-pointer list-none hover:text-gold-600 {{ request()->routeIs('catalog.*') ? 'text-gold-600' : '' }}">Shop</summary>
                <div class="absolute left-0 top-full z-20 mt-3 w-56 border border-ivory-200 bg-ivory-50 p-2 shadow-lg">
                    <a href="{{ route('catalog.index') }}" class="block px-3 py-2 text-xs normal-case tracking-normal hover:bg-ivory-100">Semua produk</a>
                    @foreach ($categories as $category)
                        <a href="{{ route('catalog.category', $category) }}" class="block px-3 py-2 text-xs normal-case tracking-normal hover:bg-ivory-100">{{ $category->name }}</a>
                    @endforeach
                </div>
            </details>
            <a href="{{ route('catalog.collection', \Illuminate\Support\Str::slug(config('company.signature_line'))) }}" class="hover:text-gold-600">{{ config('company.signature_line') }}</a>
            <a href="{{ route('catalog.sale') }}" class="hover:text-gold-600 {{ request()->routeIs('catalog.sale') ? 'text-gold-600' : '' }}">Sale</a>
            <a href="{{ route('stores') }}" class="hover:text-gold-600 {{ request()->routeIs('stores') ? 'text-gold-600' : '' }}">Toko</a>
        </nav>

        <details class="relative lg:hidden">
            <summary class="cursor-pointer list-none p-1 text-xs font-semibold uppercase tracking-[0.18em]" aria-label="Buka menu">Menu</summary>
            <div class="absolute left-0 top-full z-20 mt-3 w-64 border border-ivory-200 bg-ivory-50 p-2 shadow-lg">
                <a href="{{ route('catalog.new') }}" class="block px-3 py-2 text-sm hover:bg-ivory-100">New Arrivals</a>
                <a href="{{ route('catalog.index') }}" class="block px-3 py-2 text-sm hover:bg-ivory-100">Semua produk</a>
                @foreach ($categories as $category)
                    <a href="{{ route('catalog.category', $category) }}" class="block px-3 py-2 pl-6 text-sm text-noir-700 hover:bg-ivory-100">{{ $category->name }}</a>
                @endforeach
                <a href="{{ route('catalog.sale') }}" class="block px-3 py-2 text-sm hover:bg-ivory-100">Sale</a>
                <a href="{{ route('stores') }}" class="block px-3 py-2 text-sm hover:bg-ivory-100">Toko</a>
                <a href="{{ route('about') }}" class="block px-3 py-2 text-sm hover:bg-ivory-100">Tentang</a>
                <a href="{{ route('contact') }}" class="block px-3 py-2 text-sm hover:bg-ivory-100">Kontak</a>
            </div>
        </details>

        <a href="{{ route('home') }}" class="font-display text-2xl font-semibold tracking-[0.12em] text-noir-900 sm:text-3xl" aria-label="Beranda {{ config('company.name') }}">
            {{ strtoupper(config('company.name')) }}
        </a>

        <div class="flex items-center gap-4 text-xs font-semibold uppercase tracking-[0.18em]">
            <form action="{{ route('catalog.index') }}" method="GET" class="hidden md:block">
                <label for="header-search" class="sr-only">Cari produk</label>
                <input id="header-search" name="q" type="search" value="{{ request('q') }}" placeholder="Cari" class="w-32 border-0 border-b border-ivory-300 bg-transparent px-0 py-1 text-xs normal-case tracking-normal placeholder:text-noir-700/50 focus:border-noir-900 focus:ring-0">
            </form>
            @auth
                <a href="{{ route('admin.dashboard') }}" class="hidden hover:text-gold-600 sm:inline">Admin</a>
            @endauth
            <a href="{{ route('cart.index') }}" class="relative hover:text-gold-600" aria-label="Keranjang, {{ $cartCount }} item">
                Bag
                <span class="ml-1 inline-flex h-5 min-w-5 items-center justify-center rounded-full bg-noir-900 px-1 text-[10px] text-ivory-50">{{ $cartCount }}</span>
            </a>
        </div>
    </div>
</header>
