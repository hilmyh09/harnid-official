{{-- Lini signature: koleksi unggulan (mis. Harnid Noir). --}}
@props(['collection'])
@if ($collection)
    <section class="bg-noir-900 text-ivory-50" aria-labelledby="signature-title">
        <div class="mx-auto grid max-w-7xl items-center gap-10 px-4 py-20 sm:px-6 md:grid-cols-2">
            <div class="order-2 md:order-1">
                <p class="eyebrow text-gold-400">Signature line</p>
                <h2 id="signature-title" class="mt-3 font-display text-4xl font-medium sm:text-5xl">{{ $collection->name }}</h2>
                <p class="mt-5 max-w-md text-sm leading-relaxed text-ivory-200">{{ $collection->description }}</p>
                <a href="{{ route('catalog.collection', $collection) }}" class="btn-primary mt-8 bg-gold-500 text-noir-900 hover:bg-gold-400">Jelajahi {{ $collection->name }}</a>
            </div>
            <div class="order-1 aspect-[4/3] overflow-hidden md:order-2">
                <img src="/images/campaign/noir.jpg" alt="{{ $collection->name }}" class="h-full w-full object-cover object-top" loading="lazy">
            </div>
        </div>
    </section>
@endif
