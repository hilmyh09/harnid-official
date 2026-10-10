{{--
    Keunggulan toko: alasan berbelanja di Harnid. Tiap poin punya ikon, judul,
    dan penjelasan singkat. `$items` datang dari HomeController (data tiruan);
    ikon dipilih lewat kunci `icon` (lihat @switch di bawah).
--}}
@props(['items' => []])
<section class="border-y border-ivory-200 bg-ivory-100" aria-labelledby="benefits-title">
    <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6">
        <p class="eyebrow">Kenapa Harnid</p>
        <h2 id="benefits-title" class="mt-2 font-display text-3xl font-medium">Belanja rapi, tanpa ribet</h2>
        <ul class="mt-10 grid gap-8 sm:grid-cols-2 lg:grid-cols-4" role="list">
            @foreach ($items as $item)
                <li class="flex gap-4">
                    <span class="flex h-12 w-12 shrink-0 items-center justify-center border border-ivory-300 bg-white text-noir-900" aria-hidden="true">
                        @switch($item['icon'] ?? '')
                            @case('fabric')
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M4 7c2.5-2 5.5-2 8 0s5.5 2 8 0M4 12c2.5-2 5.5-2 8 0s5.5 2 8 0M4 17c2.5-2 5.5-2 8 0s5.5 2 8 0"/></svg>
                                @break
                            @case('truck')
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linejoin="round" d="M3 6h11v10H3zM14 9h4l3 3v4h-7z"/><circle cx="7" cy="18" r="1.8"/><circle cx="17" cy="18" r="1.8"/></svg>
                                @break
                            @case('swap')
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M4 8h13l-3-3M20 16H7l3 3"/></svg>
                                @break
                            @case('pin')
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linejoin="round" d="M12 21s-6-5.5-6-10a6 6 0 0 1 12 0c0 4.5-6 10-6 10Z"/><circle cx="12" cy="11" r="2.2"/></svg>
                                @break
                            @case('chat')
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linejoin="round" d="M4 5h16v11H9l-5 4z"/></svg>
                                @break
                            @default
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6"/></svg>
                        @endswitch
                    </span>
                    <div>
                        <p class="font-display text-xl text-noir-900">{{ $item['title'] }}</p>
                        <p class="mt-1 text-sm leading-relaxed text-noir-700">{{ $item['text'] }}</p>
                        @if (! empty($item['url']))
                            <a href="{{ $item['url'] }}" class="btn-link mt-2">{{ $item['link_label'] ?? 'Selengkapnya' }}</a>
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</section>
