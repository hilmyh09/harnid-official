<x-layouts.admin title="Produk">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <h1 class="font-display text-3xl font-medium">Produk</h1>
        <a href="{{ route('admin.products.create') }}" class="btn-primary">Tambah produk</a>
    </div>
    <form method="GET" class="mt-6 flex gap-2">
        <label for="q" class="sr-only">Cari</label>
        <input id="q" name="q" type="search" value="{{ $search }}" placeholder="Cari nama atau SKU" class="input max-w-xs">
        <button type="submit" class="btn-secondary py-2.5">Cari</button>
    </form>
    <div class="mt-4 overflow-x-auto border border-ivory-200 bg-white">
        <table class="min-w-full text-sm">
            <thead class="bg-ivory-100 text-left text-xs uppercase tracking-wider text-noir-700"><tr><th class="px-4 py-3">Produk</th><th class="px-4 py-3">Kategori</th><th class="px-4 py-3">Harga</th><th class="px-4 py-3">Stok</th><th class="px-4 py-3">Status</th><th class="px-4 py-3"></th></tr></thead>
            <tbody class="divide-y divide-ivory-200">
                @forelse ($products as $product)
                    <tr>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="h-12 w-9 shrink-0 overflow-hidden bg-ivory-200">@if ($product->imageUrl())<img src="{{ $product->imageUrl() }}" alt="" class="h-full w-full object-cover">@endif</div>
                                <div><p class="font-medium">{{ $product->name }}</p><p class="text-xs text-noir-700/60">{{ $product->sku }}</p></div>
                            </div>
                        </td>
                        <td class="px-4 py-3">{{ $product->category->name }}</td>
                        <td class="px-4 py-3">{{ rupiah($product->price) }}@if ($product->isOnSale())<br><span class="text-xs text-noir-700/60 line-through">{{ rupiah($product->compare_at_price) }}</span>@endif</td>
                        <td class="px-4 py-3 {{ $product->stock <= 3 ? 'font-semibold text-red-700' : '' }}">{{ $product->stock }}</td>
                        <td class="px-4 py-3">
                            @if ($product->isPublished())<span class="badge bg-green-100 text-green-800">Tayang</span>
                            @elseif (! $product->is_active)<span class="badge bg-gray-200 text-gray-700">Nonaktif</span>
                            @else<span class="badge bg-amber-100 text-amber-800">Draf</span>@endif
                        </td>
                        <td class="px-4 py-3 text-right whitespace-nowrap">
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn-link">Edit</a>
                            @if ($product->is_active)
                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="ml-3 inline" onsubmit="return confirm('Nonaktifkan produk ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs text-red-700 underline-offset-4 hover:underline">Nonaktifkan</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-8 text-center text-noir-700/70">Belum ada produk.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $products->links() }}</div>
</x-layouts.admin>
