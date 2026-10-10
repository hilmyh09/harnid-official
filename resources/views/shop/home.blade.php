{{--
    Halaman utama. Urutan section mengikuti PRD:
    Hero (+ Mulai Belanja) → Sorotan Produk → Kategori → New Arrivals → Signature → Lookbook → Keunggulan → Footer (di layout).
    Setiap section adalah komponen di resources/views/components/sections/.
--}}
<x-layouts.shop>
    <x-sections.hero :hero="$hero" />
    <x-sections.featured-products :products="$featuredProducts" />
    <x-sections.categories :categories="$categories" />
    <x-sections.new-arrivals :products="$newArrivals" />
    <x-sections.signature :collection="$featuredCollection" />
    <x-sections.lookbook />
    <x-sections.benefits :store-count="$storeCount" :city-count="$cityCount" />
</x-layouts.shop>
