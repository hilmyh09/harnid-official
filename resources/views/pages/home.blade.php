<x-layouts.app :description="config('company.tagline')">
    {{-- Hero / landing --}}
    <section class="bg-gradient-to-b from-brand-50 to-white">
        <div class="mx-auto grid max-w-6xl items-center gap-10 px-4 py-20 sm:px-6 md:grid-cols-2 md:py-28">
            <div>
                <p class="mb-3 inline-flex rounded-full bg-brand-100 px-3 py-1 text-xs font-semibold text-brand-700">
                    {{ config('company.name') }}
                </p>
                <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl">
                    {{ config('company.tagline') }}
                </h1>
                <p class="mt-5 text-lg text-gray-600">
                    Kami membantu perusahaan membangun kehadiran digital yang profesional: website profil, landing page, dan aplikasi web yang siap dipakai tim Anda.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('contact') }}" class="btn-primary">Hubungi Kami</a>
                    <a href="{{ route('services') }}" class="btn-secondary">Lihat Layanan</a>
                </div>
            </div>
            <div class="rounded-2xl border border-brand-100 bg-white p-8 shadow-sm">
                <dl class="grid grid-cols-2 gap-6">
                    <div><dt class="text-sm text-gray-500">Proyek selesai</dt><dd class="mt-1 text-3xl font-bold text-brand-700">50+</dd></div>
                    <div><dt class="text-sm text-gray-500">Klien aktif</dt><dd class="mt-1 text-3xl font-bold text-brand-700">20+</dd></div>
                    <div><dt class="text-sm text-gray-500">Tahun pengalaman</dt><dd class="mt-1 text-3xl font-bold text-brand-700">5</dd></div>
                    <div><dt class="text-sm text-gray-500">Dukungan</dt><dd class="mt-1 text-3xl font-bold text-brand-700">24/7</dd></div>
                </dl>
                <p class="mt-6 text-xs text-gray-400">Angka contoh; sesuaikan dengan data perusahaan Anda.</p>
            </div>
        </div>
    </section>

    <x-section title="Layanan kami" subtitle="Tiga layanan utama yang bisa disesuaikan dengan kebutuhan bisnis Anda.">
        <div class="grid gap-6 md:grid-cols-3">
            @foreach ($services as $service)
                <x-service-card :title="$service['title']" :description="$service['description']" />
            @endforeach
        </div>
    </x-section>

    <section class="bg-brand-900">
        <div class="mx-auto flex max-w-6xl flex-col items-start gap-6 px-4 py-16 sm:px-6 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-white">Siap memulai proyek Anda?</h2>
                <p class="mt-2 text-brand-100">Ceritakan kebutuhan Anda, kami balas dalam 1x24 jam kerja.</p>
            </div>
            <a href="{{ route('contact') }}" class="btn-primary bg-white text-brand-700 hover:bg-brand-50">Konsultasi gratis</a>
        </div>
    </section>
</x-layouts.app>
