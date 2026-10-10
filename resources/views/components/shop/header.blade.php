@php($cartCount = app(\App\Services\Cart::class)->count())
@php($categories = \App\Models\Category::orderBy('sort_order')->get(['name', 'slug']))
@php($collections = \App\Models\Collection::orderBy('sort_order')->get(['name', 'slug']))
<header class="sticky top-0 z-30 border-b border-ivory-200 bg-white/95 backdrop-blur">
    <div class="mx-auto grid max-w-screen-2xl grid-cols-[1fr_auto_1fr] items-center px-4 py-3 sm:px-8 sm:py-4">
        <div class="flex items-center">
            <button type="button" class="icon-btn -ml-2" data-drawer-open aria-label="Buka menu" aria-controls="site-drawer" aria-expanded="false">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
            </button>
        </div>

        <a href="{{ route('home') }}" class="justify-self-center" aria-label="Beranda {{ config('company.name') }}">
            <x-brand-logo />
        </a>

        <div class="flex items-center justify-end gap-1 sm:gap-2">
            <details class="relative">
                <summary class="icon-btn cursor-pointer list-none" aria-label="Cari produk">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m20 20-3.5-3.5"/></svg>
                </summary>
                <form action="{{ route('catalog.index') }}" method="GET" class="absolute right-0 top-full z-20 mt-2 w-72 border border-ivory-200 bg-white p-3 shadow-lg">
                    <label for="header-search" class="sr-only">Cari produk</label>
                    <div class="flex gap-2">
                        <input id="header-search" name="q" type="search" value="{{ request('q') }}" placeholder="Cari produk" class="input py-2">
                        <button type="submit" class="btn-primary px-4 py-2">Cari</button>
                    </div>
                </form>
            </details>
            <a href="{{ route('cart.index') }}" class="icon-btn relative" aria-label="Keranjang, {{ $cartCount }} item">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path stroke-linejoin="round" d="M5 8h14l-1 12H6L5 8Z"/><path stroke-linecap="round" d="M9 8V6a3 3 0 0 1 6 0v2"/></svg>
                @if ($cartCount > 0)
                    <span class="absolute -right-0.5 -top-0.5 inline-flex h-4 min-w-4 items-center justify-center rounded-full bg-noir-900 px-1 text-[10px] font-semibold text-ivory-50">{{ $cartCount }}</span>
                @endif
            </a>
            <a href="{{ auth()->check() ? route('admin.dashboard') : route('login') }}" class="icon-btn" aria-label="{{ auth()->check() ? 'Admin' : 'Masuk' }}">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path stroke-linecap="round" d="M4 20c0-3.5 3.6-6 8-6s8 2.5 8 6"/></svg>
            </a>
        </div>
    </div>
</header>

{{-- Menu samping (off-canvas) --}}
<div id="site-drawer" class="fixed inset-0 z-40 hidden" data-drawer hidden>
    <div class="absolute inset-0 bg-noir-900/40" data-drawer-close></div>
    <nav class="absolute inset-y-0 left-0 flex w-full max-w-md flex-col overflow-y-auto bg-white px-6 pb-10 pt-5 shadow-2xl sm:px-8" aria-label="Menu utama">
        <button type="button" class="icon-btn -ml-2 self-start" data-drawer-close aria-label="Tutup menu">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path stroke-linecap="round" d="M6 6l12 12M18 6 6 18"/></svg>
        </button>

        <div class="mt-6 divide-y divide-transparent">
            <a href="{{ route('catalog.new') }}" class="drawer-link">New Arrivals</a>
            <details class="group">
                <summary class="drawer-link cursor-pointer list-none">
                    <span>Kategori</span>
                    <svg class="h-5 w-5 transition group-open:rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m9 6 6 6-6 6"/></svg>
                </summary>
                <div class="pb-3">
                    <a href="{{ route('catalog.index') }}" class="drawer-sublink">Semua produk</a>
                    @foreach ($categories as $category)
                        <a href="{{ route('catalog.category', $category) }}" class="drawer-sublink">{{ $category->name }}</a>
                    @endforeach
                </div>
            </details>
            <details class="group">
                <summary class="drawer-link cursor-pointer list-none">
                    <span>Koleksi</span>
                    <svg class="h-5 w-5 transition group-open:rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m9 6 6 6-6 6"/></svg>
                </summary>
                <div class="pb-3">
                    @foreach ($collections as $collection)
                        <a href="{{ route('catalog.collection', $collection) }}" class="drawer-sublink">{{ $collection->name }}</a>
                    @endforeach
                </div>
            </details>
            <a href="{{ route('catalog.collection', \Illuminate\Support\Str::slug(config('company.signature_line'))) }}" class="drawer-link">{{ config('company.signature_line') }}</a>
            <a href="{{ route('stores') }}" class="drawer-link">Lokasi Toko</a>
            <a href="{{ route('catalog.sale') }}" class="drawer-link">Sale</a>
            <a href="{{ route('about') }}" class="drawer-link">Tentang Harnid</a>
            <a href="{{ route('size-guide') }}" class="drawer-link">Panduan Ukuran</a>
        </div>

        <hr class="my-6 border-ivory-200">

        <a href="{{ route('contact') }}" class="text-xl font-medium uppercase tracking-[0.12em] text-noir-900 hover:text-gold-600">Hubungi Kami</a>

        <div class="mt-10 flex items-center justify-around text-noir-900">
            <a href="https://instagram.com/{{ config('company.instagram') }}" target="_blank" rel="noopener" aria-label="Instagram" class="hover:text-gold-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg>
            </a>
            <a href="https://www.tiktok.com/{{ '@'.config('company.instagram') }}" target="_blank" rel="noopener" aria-label="TikTok" class="hover:text-gold-600">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M13.5 3h2.6c.2 1.9 1.5 3.4 3.4 3.7v2.6a6.3 6.3 0 0 1-3.4-1.1v6.3a5.3 5.3 0 1 1-5.3-5.3c.3 0 .6 0 .9.1v2.7a2.7 2.7 0 1 0 1.8 2.5V3Z"/></svg>
            </a>
            <a href="https://www.youtube.com/{{ '@'.config('company.instagram') }}" target="_blank" rel="noopener" aria-label="YouTube" class="hover:text-gold-600">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M21.6 7.2a2.5 2.5 0 0 0-1.8-1.8C18.2 5 12 5 12 5s-6.2 0-7.8.4A2.5 2.5 0 0 0 2.4 7.2 26 26 0 0 0 2 12a26 26 0 0 0 .4 4.8 2.5 2.5 0 0 0 1.8 1.8C5.8 19 12 19 12 19s6.2 0 7.8-.4a2.5 2.5 0 0 0 1.8-1.8A26 26 0 0 0 22 12a26 26 0 0 0-.4-4.8ZM10 15V9l5.2 3L10 15Z"/></svg>
            </a>
        </div>
    </nav>
</div>
