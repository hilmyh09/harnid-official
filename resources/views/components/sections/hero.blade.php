{{-- Hero pembuka: judul, penjelasan singkat, gambar utama, dan tombol Mulai Belanja. --}}
<section class="bg-ivory-100" aria-labelledby="hero-title">
    <div class="mx-auto grid max-w-7xl items-center gap-10 px-4 py-14 sm:px-6 md:grid-cols-2 md:py-20">
        <div class="order-2 md:order-1">
            <p class="eyebrow">Koleksi terbaru</p>
            <h1 id="hero-title" class="mt-4 max-w-xl font-display text-5xl font-medium leading-[1.05] text-noir-900 sm:text-6xl">
                Anggun di setiap<br>momen Anda.
            </h1>
            <p class="mt-5 max-w-md text-sm text-noir-700 sm:text-base">{{ config('company.tagline') }}. Ready-to-wear untuk kasual hingga formal.</p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('catalog.index') }}" class="btn-primary">Mulai Belanja</a>
                <a href="{{ route('catalog.new') }}" class="btn-secondary">New Arrivals</a>
            </div>
        </div>
        <div class="order-1 aspect-[4/5] overflow-hidden bg-ivory-200 md:order-2">
            <img src="/images/campaign/hero.jpg" alt="Tiga model mengenakan Harnid Basic Shirt warna cokelat, abu-abu, dan hitam" class="h-full w-full object-cover object-top" fetchpriority="high">
        </div>
    </div>
</section>
