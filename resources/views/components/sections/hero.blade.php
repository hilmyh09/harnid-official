{{--
    Hero pembuka: judul besar, satu kalimat penjelasan, gambar utama, dan tombol Mulai Belanja.
    Semua teks/gambar datang dari prop `$hero` (data tiruan dari HomeController) agar mudah
    diganti tanpa menyentuh markup. Nilai default di bawah dipakai bila prop tidak dikirim.
--}}
@props(['hero' => []])
@php($hero = array_merge([
    'eyebrow' => 'Koleksi terbaru',
    'title' => 'Modest fashion yang rapi, nyaman, dan siap dipakai.',
    'subtitle' => config('company.tagline').'. Ready-to-wear dari kasual hingga formal.',
    'image' => '/images/campaign/hero.jpg',
    'image_alt' => 'Tiga model mengenakan Harnid Basic Shirt warna cokelat, abu-abu, dan hitam',
    'cta_label' => 'Mulai Belanja',
    'cta_url' => route('catalog.index'),
    'secondary_label' => 'New Arrivals',
    'secondary_url' => route('catalog.new'),
], $hero))
<section class="bg-ivory-100" aria-labelledby="hero-title">
    <div class="mx-auto grid max-w-7xl items-center gap-8 px-4 py-12 sm:px-6 sm:py-14 md:grid-cols-2 md:gap-10 md:py-20">
        <div class="order-2 md:order-1">
            @if (! empty($hero['eyebrow']))
                <p class="eyebrow">{{ $hero['eyebrow'] }}</p>
            @endif
            <h1 id="hero-title" class="mt-4 max-w-xl font-display text-4xl font-medium leading-[1.08] text-noir-900 sm:text-5xl lg:text-6xl">
                {{ $hero['title'] }}
            </h1>
            <p class="mt-5 max-w-md text-base text-noir-700 sm:text-lg">{{ $hero['subtitle'] }}</p>
            <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:flex-wrap">
                {{-- Tombol utama: lebar penuh di ponsel agar mudah disentuh, minimal tinggi 48px. --}}
                <a href="{{ $hero['cta_url'] }}" class="btn-primary min-h-12 w-full px-8 text-sm sm:w-auto" data-cta="mulai-belanja">{{ $hero['cta_label'] }}</a>
                @if (! empty($hero['secondary_label']))
                    <a href="{{ $hero['secondary_url'] }}" class="btn-secondary min-h-12 w-full sm:w-auto">{{ $hero['secondary_label'] }}</a>
                @endif
            </div>
        </div>
        <div class="order-1 aspect-[4/5] overflow-hidden bg-ivory-200 md:order-2">
            <img src="{{ $hero['image'] }}" alt="{{ $hero['image_alt'] }}" width="1333" height="2000" class="h-full w-full object-cover object-top" fetchpriority="high" decoding="async">
        </div>
    </div>
</section>
