@props(['href', 'active' => false])
<a href="{{ $href }}" {{ $attributes->class(['transition hover:text-brand-700', 'text-brand-700' => $active]) }} @if($active) aria-current="page" @endif>
    {{ $slot }}
</a>
