@props(['product'])
<a href="{{ route('product.show', $product) }}" class="group block">
    <div class="relative aspect-[3/4] overflow-hidden bg-ivory-200">
        @if ($product->imageUrl())
            <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" loading="lazy" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
        @else
            <div class="flex h-full items-center justify-center text-xs uppercase tracking-widest text-noir-700/50">Tanpa gambar</div>
        @endif
        @if ($product->isOnSale())
            <span class="absolute left-3 top-3 bg-noir-900 px-2 py-1 text-[10px] font-semibold uppercase tracking-widest text-ivory-50">-{{ $product->discountPercent() }}%</span>
        @elseif ($product->published_at && $product->published_at->gte(now()->subDays(14)))
            <span class="absolute left-3 top-3 bg-ivory-50 px-2 py-1 text-[10px] font-semibold uppercase tracking-widest text-noir-900">Baru</span>
        @endif
        @if ($product->stock < 1)
            <span class="absolute inset-x-0 bottom-0 bg-noir-900/80 py-2 text-center text-[10px] font-semibold uppercase tracking-widest text-ivory-50">Habis</span>
        @endif
    </div>
    <div class="mt-3">
        <p class="text-[11px] uppercase tracking-widest text-noir-700/60">{{ $product->category->name }}</p>
        <h3 class="mt-1 font-sans text-sm font-medium text-noir-900 group-hover:underline">{{ $product->name }}</h3>
        <x-price :product="$product" class="mt-1 text-sm" />
    </div>
</a>
