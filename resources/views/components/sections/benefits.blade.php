{{-- Keunggulan toko: alasan berbelanja di Harnid. --}}
@props(['storeCount' => 0, 'cityCount' => 0])
<section class="border-y border-ivory-200 bg-ivory-100" aria-labelledby="benefits-title">
    <h2 id="benefits-title" class="sr-only">Keunggulan Harnid</h2>
    <div class="mx-auto grid max-w-7xl gap-8 px-4 py-12 sm:px-6 md:grid-cols-4">
        <div><p class="font-display text-2xl">Bahan premium</p><p class="mt-1 text-sm text-noir-700">Dipilih untuk nyaman dipakai seharian.</p></div>
        <div><p class="font-display text-2xl">Worldwide shipping</p><p class="mt-1 text-sm text-noir-700">Kirim ke seluruh Indonesia dan luar negeri.</p></div>
        <div><p class="font-display text-2xl">Tukar ukuran</p><p class="mt-1 text-sm text-noir-700">Penukaran ukuran dalam 7 hari.*</p></div>
        <div><p class="font-display text-2xl">{{ $storeCount }} toko, {{ $cityCount }} kota</p><p class="mt-1 text-sm text-noir-700"><a href="{{ route('stores') }}" class="underline underline-offset-4">Lihat lokasi toko</a></p></div>
    </div>
</section>
