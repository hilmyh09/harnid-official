<x-layouts.app title="Tentang Kami">
    <x-section title="Tentang {{ config('company.name') }}" subtitle="Siapa kami dan apa yang kami kerjakan.">
        <div class="grid gap-10 md:grid-cols-2">
            <div class="space-y-4 text-gray-700">
                <p>{{ config('company.name') }} adalah tim pengembang web yang fokus pada solusi praktis untuk bisnis: tampil profesional di internet dan mengelola pekerjaan lewat aplikasi yang sederhana.</p>
                <p>Kami percaya website yang baik harus cepat, mudah dirawat, dan jelas tujuannya. Setiap proyek kami mulai dari kebutuhan nyata, bukan dari fitur yang tidak terpakai.</p>
                <p class="text-sm text-gray-500">Teks ini adalah contoh; ganti dengan profil perusahaan yang sebenarnya.</p>
            </div>
            <div class="grid gap-4">
                <div class="rounded-xl border border-gray-200 p-5">
                    <h3 class="font-semibold">Visi</h3>
                    <p class="mt-1 text-sm text-gray-600">Menjadi mitra digital tepercaya bagi usaha kecil dan menengah di Indonesia.</p>
                </div>
                <div class="rounded-xl border border-gray-200 p-5">
                    <h3 class="font-semibold">Misi</h3>
                    <p class="mt-1 text-sm text-gray-600">Menghadirkan website dan aplikasi yang ringan, aman, dan mudah digunakan dengan biaya yang masuk akal.</p>
                </div>
                <div class="rounded-xl border border-gray-200 p-5">
                    <h3 class="font-semibold">Nilai</h3>
                    <p class="mt-1 text-sm text-gray-600">Jujur, tepat waktu, dan berorientasi pada hasil yang terukur.</p>
                </div>
            </div>
        </div>
    </x-section>
</x-layouts.app>
