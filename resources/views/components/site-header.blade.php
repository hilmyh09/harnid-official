<header class="border-b border-gray-100 bg-white">
    <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4 sm:px-6">
        <a href="{{ route('home') }}" class="text-lg font-bold tracking-tight text-brand-700">
            {{ config('company.name') }}
        </a>

        <nav class="hidden items-center gap-6 text-sm font-medium text-gray-700 md:flex" aria-label="Navigasi utama">
            <x-nav-link :href="route('home')" :active="request()->routeIs('home')">Beranda</x-nav-link>
            <x-nav-link :href="route('about')" :active="request()->routeIs('about')">Tentang</x-nav-link>
            <x-nav-link :href="route('services')" :active="request()->routeIs('services')">Layanan</x-nav-link>
            <x-nav-link :href="route('contact')" :active="request()->routeIs('contact')">Kontak</x-nav-link>
        </nav>

        <div class="flex items-center gap-3">
            @auth
                <a href="{{ route('dashboard') }}" class="btn-secondary">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn-secondary">Masuk</a>
            @endauth
            <details class="relative md:hidden">
                <summary class="btn-secondary cursor-pointer list-none px-3" aria-label="Buka menu">☰</summary>
                <div class="absolute right-0 z-20 mt-2 w-44 rounded-lg border border-gray-200 bg-white p-2 shadow-lg">
                    <a class="block rounded px-3 py-2 text-sm hover:bg-gray-50" href="{{ route('home') }}">Beranda</a>
                    <a class="block rounded px-3 py-2 text-sm hover:bg-gray-50" href="{{ route('about') }}">Tentang</a>
                    <a class="block rounded px-3 py-2 text-sm hover:bg-gray-50" href="{{ route('services') }}">Layanan</a>
                    <a class="block rounded px-3 py-2 text-sm hover:bg-gray-50" href="{{ route('contact') }}">Kontak</a>
                </div>
            </details>
        </div>
    </div>
</header>
