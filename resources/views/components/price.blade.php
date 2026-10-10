@props(['product'])
<p {{ $attributes->class(['flex items-baseline gap-2']) }}>
    <span class="font-medium text-noir-900">{{ rupiah($product->price) }}</span>
    @if ($product->isOnSale())
        <span class="text-noir-700/50 line-through">{{ rupiah($product->compare_at_price) }}</span>
    @endif
</p>
