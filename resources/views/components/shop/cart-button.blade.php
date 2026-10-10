{{--
    Ikon keranjang di navbar dengan badge jumlah barang.
    - Badge disembunyikan saat keranjang kosong (hidden), ditampilkan lagi oleh JS lewat
      [data-cart-count] bila jumlah berubah tanpa reload. Tampilan dibatasi "99+".
--}}
@props(['count' => 0])
@php($label = $count > 99 ? '99+' : (string) $count)
<a href="{{ route('cart.index') }}" {{ $attributes->class(['icon-btn relative']) }} aria-label="Keranjang, {{ $count }} item" data-cart-link>
    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path stroke-linejoin="round" d="M5 8h14l-1 12H6L5 8Z"/><path stroke-linecap="round" d="M9 8V6a3 3 0 0 1 6 0v2"/></svg>
    <span class="absolute -right-0.5 -top-0.5 inline-flex h-4 min-w-4 items-center justify-center rounded-full bg-noir-900 px-1 text-[10px] font-semibold leading-none text-ivory-50 {{ $count > 0 ? '' : 'hidden' }}" data-cart-count="{{ $count }}" aria-hidden="true">{{ $label }}</span>
</a>
