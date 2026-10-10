<x-layouts.shop title="Tentang Kami">
    <section class="mx-auto max-w-4xl px-4 py-16 sm:px-6">
        <p class="eyebrow">Tentang {{ config('company.name') }}</p>
        <h1 class="mt-2 font-display text-5xl font-medium leading-tight">Modest, modern, dan dibuat dengan teliti.</h1>
        <div class="mt-8 space-y-5 text-base leading-relaxed text-noir-700">
            <p>{{ config('company.name') }} lahir pada {{ config('company.founded_year') }} dari keinginan sederhana: busana modest yang anggun tanpa mengorbankan kenyamanan. Setiap koleksi dirancang untuk perempuan yang ingin tampil rapi dari pagi hingga malam.</p>
            <p>Kami memilih bahan yang jatuh dan adem, memperhatikan jahitan hingga detail terkecil, dan menjaga harga tetap masuk akal. Lini signature <strong>{{ config('company.signature_line') }}</strong> menghadirkan siluet tegas dengan palet gelap yang mewah.</p>
            <p class="text-sm text-noir-700/70">Teks ini contoh; ganti dengan cerita brand Anda yang sebenarnya.</p>
        </div>
        <div class="mt-10 aspect-[3/4] max-w-md overflow-hidden bg-ivory-200">
            <img src="/images/campaign/about.jpg" alt="Model mengenakan Harnid Basic Shirt Cokelat" class="h-full w-full object-cover" loading="lazy">
        </div>
        <div class="mt-12 grid gap-6 sm:grid-cols-3">
            <div class="border border-ivory-200 bg-white p-6"><p class="font-display text-3xl">Premium</p><p class="mt-1 text-sm text-noir-700">Bahan dan jahitan pilihan.</p></div>
            <div class="border border-ivory-200 bg-white p-6"><p class="font-display text-3xl">Lokal</p><p class="mt-1 text-sm text-noir-700">Diproduksi bersama penjahit Indonesia.</p></div>
            <div class="border border-ivory-200 bg-white p-6"><p class="font-display text-3xl">Timeless</p><p class="mt-1 text-sm text-noir-700">Desain yang tetap relevan bertahun-tahun.</p></div>
        </div>
    </section>
</x-layouts.shop>
