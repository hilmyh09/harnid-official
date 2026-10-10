<footer class="mt-24 border-t border-ivory-200 bg-ivory-100">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-14 sm:px-6 md:grid-cols-4">
        <div class="md:col-span-2">
            <p class="font-display text-2xl font-semibold tracking-[0.12em]">{{ strtoupper(config('company.name')) }}</p>
            <p class="mt-3 max-w-sm text-sm text-noir-700">{{ config('company.tagline') }}. Sejak {{ config('company.founded_year') }}.</p>
            <form class="mt-6 flex max-w-sm gap-2" action="{{ route('contact') }}" method="GET">
                <label for="newsletter" class="sr-only">Email</label>
                <input id="newsletter" type="email" class="input" placeholder="Email Anda" disabled>
                <button type="submit" class="btn-primary shrink-0">Hubungi</button>
            </form>
            <p class="mt-2 text-xs text-noir-700/60">Newsletter belum aktif; gunakan halaman kontak.</p>
        </div>
        <div class="text-sm">
            <p class="eyebrow">Belanja</p>
            <ul class="mt-3 space-y-2 text-noir-700">
                <li><a class="hover:text-noir-900" href="{{ route('catalog.new') }}">New Arrivals</a></li>
                <li><a class="hover:text-noir-900" href="{{ route('catalog.index') }}">Semua produk</a></li>
                <li><a class="hover:text-noir-900" href="{{ route('catalog.sale') }}">Sale</a></li>
                <li><a class="hover:text-noir-900" href="{{ route('size-guide') }}">Panduan ukuran</a></li>
            </ul>
        </div>
        <div class="text-sm">
            <p class="eyebrow">Harnid</p>
            <ul class="mt-3 space-y-2 text-noir-700">
                <li><a class="hover:text-noir-900" href="{{ route('about') }}">Tentang kami</a></li>
                <li><a class="hover:text-noir-900" href="{{ route('stores') }}">Lokasi toko</a></li>
                <li><a class="hover:text-noir-900" href="{{ route('contact') }}">Kontak</a></li>
                <li><a class="hover:text-noir-900" href="https://instagram.com/{{ config('company.instagram') }}" target="_blank" rel="noopener">Instagram @{{ config('company.instagram') }}</a></li>
            </ul>
        </div>
    </div>
    <div class="border-t border-ivory-200 py-4 text-center text-xs text-noir-700/70">
        &copy; {{ date('Y') }} {{ config('company.name') }}. Hak cipta dilindungi.
    </div>
</footer>
