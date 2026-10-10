@props(['size' => 'md', 'light' => false])
@php($markClass = match ($size) { 'sm' => 'h-6 w-6', 'lg' => 'h-12 w-12', default => 'h-7 w-7 sm:h-9 sm:w-9' })
@php($textClass = match ($size) { 'sm' => 'text-sm', 'lg' => 'text-2xl', default => 'text-[13px] tracking-[0.18em] sm:text-lg sm:tracking-[0.28em]' })
<span {{ $attributes->class(['inline-flex items-center gap-2.5']) }}>
    <img src="/images/brand/mark-256.png" alt="" class="{{ $markClass }} shrink-0 object-contain" @if($light) style="filter: brightness(0) invert(0.92) sepia(0.3) saturate(2) hue-rotate(5deg)" @endif>
    <span class="font-display {{ $textClass }} whitespace-nowrap font-medium leading-none {{ $light ? 'text-ivory-50' : 'text-noir-900' }}">HARNID OFFICIAL</span>
</span>
