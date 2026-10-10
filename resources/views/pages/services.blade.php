<x-layouts.app title="Layanan">
    <x-section title="Layanan" subtitle="Pilih layanan yang sesuai, atau gabungkan sesuai kebutuhan.">
        <div class="grid gap-6 md:grid-cols-3">
            @foreach ($services as $service)
                <x-service-card :title="$service['title']" :description="$service['description']" />
            @endforeach
        </div>
        <div class="mt-10">
            <a href="{{ route('contact') }}" class="btn-primary">Minta penawaran</a>
        </div>
    </x-section>
</x-layouts.app>
