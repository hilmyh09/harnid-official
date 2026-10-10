@props(['title' => null, 'subtitle' => null])
<section {{ $attributes->class(['mx-auto max-w-6xl px-4 py-16 sm:px-6']) }}>
    @if ($title)
        <div class="mb-10 max-w-2xl">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900">{{ $title }}</h2>
            @if ($subtitle)
                <p class="mt-3 text-base text-gray-600">{{ $subtitle }}</p>
            @endif
        </div>
    @endif
    {{ $slot }}
</section>
