<footer class="mt-20 border-t border-gray-100 bg-gray-50">
    <div class="mx-auto grid max-w-6xl gap-8 px-4 py-10 sm:px-6 md:grid-cols-3">
        <div>
            <p class="text-base font-bold text-brand-700">{{ config('company.name') }}</p>
            <p class="mt-2 text-sm text-gray-600">{{ config('company.tagline') }}</p>
        </div>
        <div class="text-sm text-gray-600">
            <p class="font-semibold text-gray-800">Kontak</p>
            <p class="mt-2">{{ config('company.email') }}</p>
            <p>{{ config('company.phone') }}</p>
            <p>{{ config('company.address') }}</p>
        </div>
        <div class="text-sm text-gray-600">
            <p class="font-semibold text-gray-800">Halaman</p>
            <ul class="mt-2 space-y-1">
                <li><a class="hover:text-brand-700" href="{{ route('about') }}">Tentang</a></li>
                <li><a class="hover:text-brand-700" href="{{ route('services') }}">Layanan</a></li>
                <li><a class="hover:text-brand-700" href="{{ route('contact') }}">Kontak</a></li>
            </ul>
        </div>
    </div>
    <div class="border-t border-gray-200 py-4 text-center text-xs text-gray-500">
        &copy; {{ date('Y') }} {{ config('company.name') }}. Hak cipta dilindungi.
    </div>
</footer>
