<x-layouts.shop title="Lokasi Toko">
    <section class="mx-auto max-w-5xl px-4 py-16 sm:px-6">
        <p class="eyebrow">Store locator</p>
        <h1 class="mt-2 font-display text-4xl font-medium">Kunjungi toko kami</h1>
        @forelse ($storesByCity as $city => $stores)
            <div class="mt-10">
                <h2 class="font-display text-2xl font-medium">{{ $city }}</h2>
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    @foreach ($stores as $store)
                        <div class="border border-ivory-200 bg-white p-5 text-sm">
                            <p class="font-medium text-noir-900">{{ $store->name }}</p>
                            <p class="mt-1 text-noir-700">{{ $store->address }}</p>
                            @if ($store->hours)<p class="mt-1 text-noir-700/70">Buka {{ $store->hours }}</p>@endif
                            @if ($store->phone)<p class="mt-1 text-noir-700/70">{{ $store->phone }}</p>@endif
                            @if ($store->maps_url)<a href="{{ $store->maps_url }}" target="_blank" rel="noopener" class="btn-link mt-3">Buka peta</a>@endif
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <p class="mt-8 text-sm text-noir-700">Belum ada toko terdaftar.</p>
        @endforelse
    </section>
</x-layouts.shop>
