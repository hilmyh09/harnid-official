{{--
    Logo & nama toko. Dipakai di navbar, footer, login, dan admin.
    - `href`  : bila diisi, seluruh komponen menjadi tautan (default navbar: ke beranda).
    - `size`  : sm | md | lg. Mark memakai width/height tetap dan object-contain agar tidak gepeng.
    - `light` : versi terang untuk latar gelap.
    - `text`  : nama toko; default dari config company.name.
--}}
@props(['size' => 'md', 'light' => false, 'href' => null, 'text' => null])
@php($text ??= config('company.name'))
@php($markClass = match ($size) { 'sm' => 'h-6 w-6', 'lg' => 'h-12 w-12', default => 'h-7 w-7 sm:h-9 sm:w-9' })
@php($textClass = match ($size) { 'sm' => 'text-sm', 'lg' => 'text-2xl', default => 'text-[13px] tracking-[0.18em] sm:text-lg sm:tracking-[0.28em]' })
@php($tag = $href ? 'a' : 'span')
@php($linkAttrs = $href ? ['href' => $href, 'aria-label' => 'Beranda '.$text] : [])
<{{ $tag }} {{ $attributes->merge($linkAttrs)->class(['inline-flex items-center gap-2.5', 'focus:outline-none focus-visible:ring-2 focus-visible:ring-gold-500' => $href]) }}>
    <img src="/images/brand/mark-256.png" alt="" width="256" height="256" class="{{ $markClass }} shrink-0 object-contain" @if($light) style="filter: brightness(0) invert(0.92) sepia(0.3) saturate(2) hue-rotate(5deg)" @endif>
    <span class="font-display {{ $textClass }} whitespace-nowrap font-medium uppercase leading-none {{ $light ? 'text-ivory-50' : 'text-noir-900' }}">{{ $text }}</span>
</{{ $tag }}>
