@props(['size' => 'md', 'light' => false])
@php($markClass = match ($size) { 'sm' => 'h-6 w-6', 'lg' => 'h-12 w-12', default => 'h-8 w-8 sm:h-9 sm:w-9' })
@php($textClass = match ($size) { 'sm' => 'text-base', 'lg' => 'text-3xl', default => 'text-xl sm:text-2xl' })
<span {{ $attributes->class(['inline-flex items-center gap-2.5']) }}>
    <img src="/images/brand/mark-256.png" alt="" class="{{ $markClass }} shrink-0 object-contain" @if($light) style="filter: brightness(0) invert(0.92) sepia(0.3) saturate(2) hue-rotate(5deg)" @endif>
    <span class="font-display {{ $textClass }} font-semibold leading-none tracking-[0.14em] {{ $light ? 'text-ivory-50' : 'text-noir-900' }}">HARNID <span class="font-normal">OFFICIAL</span></span>
</span>
