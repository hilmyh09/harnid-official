{{-- Kaki halaman global: identitas toko, kontak, dan tautan penting. Tampil di semua halaman toko. --}}
@php($phoneHref = 'tel:'.preg_replace('/[^0-9+]/', '', config('company.phone')))
<footer class="mt-24 border-t border-ivory-200 bg-ivory-100" aria-labelledby="footer-title">
    <h2 id="footer-title" class="sr-only">Informasi {{ config('company.name') }}</h2>
    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-14 sm:px-6 sm:grid-cols-2 lg:grid-cols-5">
        {{-- Identitas + kontak --}}
        <div class="sm:col-span-2">
            <a href="{{ route('home') }}" class="inline-block" aria-label="Beranda {{ config('company.name') }}"><x-brand-logo /></a>
            <p class="mt-3 max-w-sm text-sm text-noir-700">{{ config('company.tagline') }}. Sejak {{ config('company.founded_year') }}.</p>
            <address class="mt-6 space-y-2 text-sm not-italic text-noir-700">
                <p><span class="eyebrow block">Email</span><a class="hover:text-noir-900" href="mailto:{{ config('company.email') }}">{{ config('company.email') }}</a></p>
                <p><span class="eyebrow block">Telepon / WhatsApp</span><a class="hover:text-noir-900" href="{{ $phoneHref }}">{{ config('company.phone') }}</a></p>
                <p><span class="eyebrow block">Alamat</span>{{ config('company.address') }}</p>
            </address>
        </div>

        {{-- Tautan utama (sama dengan menu navigasi) --}}
        <nav class="text-sm" aria-label="Tautan utama">
            <p class="eyebrow">Navigasi</p>
            <ul class="mt-3 space-y-2 text-noir-700">
                <li><a class="hover:text-noir-900" href="{{ route('home') }}">Beranda</a></li>
                <li><a class="hover:text-noir-900" href="{{ route('catalog.index') }}">Produk</a></li>
                <li><a class="hover:text-noir-900" href="{{ route('contact') }}">Kontak</a></li>
            </ul>
        </nav>

        <nav class="text-sm" aria-label="Belanja">
            <p class="eyebrow">Belanja</p>
            <ul class="mt-3 space-y-2 text-noir-700">
                <li><a class="hover:text-noir-900" href="{{ route('catalog.new') }}">New Arrivals</a></li>
                <li><a class="hover:text-noir-900" href="{{ route('catalog.sale') }}">Sale</a></li>
                <li><a class="hover:text-noir-900" href="{{ route('size-guide') }}">Panduan ukuran</a></li>
                <li><a class="hover:text-noir-900" href="{{ route('cart.index') }}">Keranjang</a></li>
            </ul>
        </nav>

        <nav class="text-sm" aria-label="Tentang Harnid">
            <p class="eyebrow">Harnid</p>
            <ul class="mt-3 space-y-2 text-noir-700">
                <li><a class="hover:text-noir-900" href="{{ route('about') }}">Tentang kami</a></li>
                <li><a class="hover:text-noir-900" href="{{ route('stores') }}">Lokasi toko</a></li>
                <li><a class="hover:text-noir-900" href="https://instagram.com/{{ config('company.instagram') }}" target="_blank" rel="noopener">Instagram @{{ config('company.instagram') }}</a></li>
                <li><a class="hover:text-noir-900" href="https://wa.me/{{ config('company.whatsapp') }}" target="_blank" rel="noopener">Chat WhatsApp</a></li>
            </ul>
        </nav>
    </div>
    <div class="border-t border-ivory-200 px-4 py-4 text-center text-xs text-noir-700/70">
        &copy; {{ date('Y') }} {{ config('company.name') }}. Hak cipta dilindungi.
    </div>
</footer>
